<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "university";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stuid = $_SESSION['stuid'];
$subid = $_SESSION['subid'];
$fltyid = $_SESSION['fltyid'];

// Fetch faculty details based on the subject ID
$sql = "SELECT f.fltyid, f.fltyname FROM FACULTY f
        JOIN FACULTY_SUBJECT fs ON f.fltyid = fs.fltyid
        JOIN SUBJECTS s ON fs.subid = s.subid
        WHERE s.subid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $subid);
$stmt->execute();
$stmt->bind_result($fltyid, $facultyName);
$stmt->fetch();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $q1 = $_POST['q1'];
    $q2 = $_POST['q2'];
    $q3 = $_POST['q3'];
    $q4 = $_POST['q4'];
    $q5 = $_POST['q5'];

    $content = "Explanation: $q1, Teaching Methods: $q2, Engagement: $q3, Punctuality: $q4, Overall: $q5";

    $sql = "INSERT INTO FEEDBACK (stuid, subid, fltyid, content) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiis", $stuid, $subid, $fltyid, $content);

    if ($stmt->execute()) {
        $thankYouMessage = "Thank you for your review! Here are your ratings:";
        $ratings = [
            'Explanation of the subject' => $q1,
            'Teaching methods' => $q2,
            'Engagement with students' => $q3,
            'Punctuality' => $q4,
            'Overall satisfaction' => $q5
        ];

        $subjectName = htmlspecialchars($_SESSION['subname']);
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Submission</title>
    <style>
        /* General page styling */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 20px;
            line-height: 1.6;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        /* Header section styling */
        .header {
            text-align: center;
            padding-bottom: 10px;
            border-bottom: 2px solid #eee;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 24px;
            color: #2c3e50;
        }

        .header h2 {
            font-size: 18px;
            color: #7f8c8d;
            font-style: italic;
        }

        /* Feedback summary styling */
        .feedback-summary {
            background-color: #f1f1f1;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .feedback-summary h3 {
            margin-top: 0;
            font-size: 20px;
            color: #3498db;
        }

        .feedback-summary p {
            font-size: 16px;
            color: #34495e;
        }

        .feedback-summary p strong {
            color: #2c3e50;
        }

        /* Success message styling */
        .success-message {
            background-color: #ecf0f1;
            border: 1px solid #dcdcdc;
            padding: 10px;
            border-radius: 8px;
            color: #27ae60;
            text-align: center;
            font-size: 18px;
            margin-bottom: 20px;
        }

        /* Table styling for ratings */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th, table td {
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #f8f8f8;
            color: #7f8c8d;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        table td {
            font-size: 16px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }

            table th, table td {
                font-size: 14px;
                padding: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header Section -->
        <div class="header">
            <h1>Subject: <?php echo $subjectName; ?></h1>
            <h2>Faculty: <?php echo htmlspecialchars($facultyName); ?></h2>
        </div>

        <!-- Success Message -->
        <div class="success-message">
            <?php echo $thankYouMessage; ?>
        </div>

        <!-- Feedback Summary -->
        <div class="feedback-summary">
            <h3>Your Ratings:</h3>
            <table>
                <thead>
                    <tr>
                        <th>Criteria</th>
                        <th>Rating</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ratings as $criteria => $rating): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($criteria); ?></td>
                        <td><?php echo htmlspecialchars($rating); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
