<?php
// Assuming $studentName and $subjects are fetched from the database
$studentName = "John Doe";  // Example student name
$subjects = ["Math", "Science", "History", "English"]; // Example subjects

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
        <h1>Welcome, <?php echo $studentName; ?></h1>
        <p class="feedback-prompt">Give your Feedback</p>

        <ul class="subject-list">
            <?php foreach ($subjects as $subject): ?>
                <li><a href="/feedback.php?subject=<?php echo urlencode($subject); ?>"><?php echo htmlspecialchars($subject); ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
