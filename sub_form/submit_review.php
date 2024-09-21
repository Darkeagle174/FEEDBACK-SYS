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
        echo "Thank you for your review! Here are your ratings: <br>";
        echo "1. Explanation of the subject: $q1<br>";
        echo "2. Teaching methods: $q2<br>";
        echo "3. Engagement with students: $q3<br>";
        echo "4. Punctuality: $q4<br>";
        echo "5. Overall satisfaction: $q5<br>";

        // Display the subject and faculty names
        echo "<br>Subject: " . htmlspecialchars($_SESSION['subname']) . "<br>";
        echo "Faculty: " . htmlspecialchars($facultyName) . "<br>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
