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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $stmt = $conn->prepare("SELECT stuid FROM STU_LOGIN WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $user, $pass);

    $stmt->execute();
    $stmt->bind_result($stuid);
    $stmt->fetch();

    if ($stuid) {
        $_SESSION['stuid'] = $stuid; // Save stuid in session
        header("Location: http://localhost/uni/Student/home/index.php");
        exit();
    } else {
        echo "Invalid username or password";
    }

    $stmt->close();
}

$conn->close();
?>
