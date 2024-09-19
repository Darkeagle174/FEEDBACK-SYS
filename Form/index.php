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
    <h2>Faculty Review Form</h2>
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
</body>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $q1 = $_POST['q1'];
    $q2 = $_POST['q2'];
    $q3 = $_POST['q3'];
    $q4 = $_POST['q4'];
    $q5 = $_POST['q5'];

    echo "Thank you for your review! Here are your ratings: <br>";
    echo "1. Explanation of the subject: $q1<br>";
    echo "2. Teaching methods: $q2<br>";
    echo "3. Engagement with students: $q3<br>";
    echo "4. Punctuality: $q4<br>";
    echo "5. Overall satisfaction: $q5<br>";
}
?>

</html>
