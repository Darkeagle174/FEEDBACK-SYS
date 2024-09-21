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

$subid = $_SESSION['subid'];
$subname = $_SESSION['subname'];
$stuid = $_SESSION['stuid'];

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

$_SESSION['fltyid'] = $fltyid;

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 400px;
            width: 100%;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        p {
            margin: 10px 0;
            color: #555;
        }
        input[type="radio"] {
            margin-right: 10px;
        }
        input[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="heading">
        <h2>Faculty Review Form</h2>
        <p>Subject: <?php echo htmlspecialchars($subname); ?></p>
        <p>Faculty: <?php echo htmlspecialchars($facultyName); ?></p>
    </div>
    <div class="form">
        <form action="submit_review.php" method="POST">
            <p>1. How well does the faculty explain the subject?</p>
            <input type="radio" name="q1" value="1" required> 1
            <input type="radio" name="q1" value="2"> 2
            <input type="radio" name="q1" value="3"> 3
            <input type="radio" name="q1" value="4"> 4
            <input type="radio" name="q1" value="5"> 5

            <p>2. How effective are the faculty's teaching methods?</p>
            <input type="radio" name="q2" value="1" required> 1
            <input type="radio" name="q2" value="2"> 2
            <input type="radio" name="q2" value="3"> 3
            <input type="radio" name="q2" value="4"> 4
            <input type="radio" name="q2" value="5"> 5

            <p>3. How well does the faculty engage with the students?</p>
            <input type="radio" name="q3" value="1" required> 1
            <input type="radio" name="q3" value="2"> 2
            <input type="radio" name="q3" value="3"> 3
            <input type="radio" name="q3" value="4"> 4
            <input type="radio" name="q3" value="5"> 5

            <p>4. How punctual is the faculty?</p>
            <input type="radio" name="q4" value="1" required> 1
            <input type="radio" name="q4" value="2"> 2
            <input type="radio" name="q4" value="3"> 3
            <input type="radio" name="q4" value="4"> 4
            <input type="radio" name="q4" value="5"> 5

            <p>5. Overall, how satisfied are you with the faculty's performance?</p>
            <input type="radio" name="q5" value="1" required> 1
            <input type="radio" name="q5" value="2"> 2
            <input type="radio" name="q5" value="3"> 3
            <input type="radio" name="q5" value="4"> 4
            <input type="radio" name="q5" value="5"> 5

            <br><br>
            <input type="submit" value="Submit Review">
        </form>
    </div>
</body>
</html>
