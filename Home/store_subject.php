<?php
session_start();

if (isset($_GET['subid']) && isset($_GET['subname'])) {
    $_SESSION['subid'] = $_GET['subid'];
    $_SESSION['subname'] = $_GET['subname'];
    header("Location: http://localhost/uni/Student/sub_form/");
    exit();
}
?>

