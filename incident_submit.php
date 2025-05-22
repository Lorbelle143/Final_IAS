<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CAPTCHA
    $userCaptcha = $_POST['captcha'] ?? '';
    $correctCaptcha = $_SESSION['captcha_answer'] ?? null;

    if ($userCaptcha != $correctCaptcha) {
        echo "<h3 style='color:red; text-align:center;'>❌ Incorrect CAPTCHA answer.</h3>";
        echo "<div style='text-align:center;'><a href='index.php'>Try Again</a></div>";
        exit();
    }

    // Get and sanitize inputs
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $impact = $_POST['impact'] ?? 'Low';

    if (empty($name) || empty($email) || empty($description)) {
        echo "<h3 style='color:red; text-align:center;'>Please fill all required fields.</h3>";
        echo "<div style='text-align:center;'><a href='index.php'>Go Back</a></div>";
        exit();
    }

    $id = uniqid('INC');
    $timestamp = date("Y-m-d H:i:s");

    $incident = [
        'id' => $id,
        'name' => htmlspecialchars($name),
        'email' => htmlspecialchars($email),
        'description' => htmlspecialchars($description),
        'impact' => $impact,
        'status' => 'Pending',
        'timestamp' => $timestamp
    ];

    $filename = 'incidents.json';
    $incidents = file_exists($filename) ? json_decode(file_get_contents($filename), true) : [];
    $incidents[] = $incident;
    file_put_contents($filename, json_encode($incidents, JSON_PRETTY_PRINT));

    file_put_contents('incident_log.txt', "[$timestamp] New Incident {$id} submitted by {$email}\n", FILE_APPEND);

} else {
    echo "Invalid access. <a href='index.php'>Go Back</a>";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Incident Submitted</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container" style="text-align:center;">
    <h2>Incident Submitted Successfully!</h2>
    <p>Your Incident ID is: <strong><?= $id ?></strong></p>
    <a href="index.php">Submit Another</a> | <a href="dashboard.php">View Incidents</a>
</div>
</body>
</html>
