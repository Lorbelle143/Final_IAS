<?php
session_start();
$number1 = rand(1, 10);
$number2 = rand(1, 10);
$_SESSION['captcha_answer'] = $number1 + $number2;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Incident Report</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Report an Incident</h2>
    <form action="incident_submit.php" method="POST">
        <label>Name</label>
        <input type="text" name="name" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Description</label>
        <textarea name="description" required></textarea>

        <label>Impact Level</label>
        <select name="impact" required>
            <option value="Low">Low</option>
            <option value="Medium" selected>Medium</option>
            <option value="High">High</option>
        </select>

        <label>Solve: <?= $number1 ?> + <?= $number2 ?> = ?</label>
        <input type="number" name="captcha" required>

        <button type="submit">Submit Incident</button>
    </form>
</div>
</body>
</html>
