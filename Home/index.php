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

$sql = "SELECT semid FROM STUDENTS WHERE stuid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $stuid);
$stmt->execute();
$stmt->bind_result($semid);
$stmt->fetch();
$stmt->close();

$sql = "SELECT semno FROM SEMESTER WHERE semid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $semid);
$stmt->execute();
$stmt->bind_result($semno);
$stmt->fetch();
$stmt->close();

$sql = "SELECT stuname FROM STUDENTS WHERE stuid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $stuid);
$stmt->execute();
$stmt->bind_result($studentName);
$stmt->fetch();
$stmt->close();

$sql = "SELECT subid, subname FROM SUBJECTS WHERE semid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $semid);
$stmt->execute();
$result = $stmt->get_result();

$subjects = [];
while ($row = $result->fetch_assoc()) {
    $subjects[] = $row;
}

$_SESSION['subjects'] = $subjects;

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($studentName); ?></h1>
        <p class="feedback-prompt">You are in semester: <?php echo htmlspecialchars($semno); ?></p>

        <ul class="subject-list">
            <?php foreach ($_SESSION['subjects'] as $subject): ?>
                <li><a href="store_subject.php?subid=<?php echo urlencode($subject['subid']); ?>&subname=<?php echo urlencode($subject['subname']); ?>"><?php echo htmlspecialchars($subject['subname']); ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
