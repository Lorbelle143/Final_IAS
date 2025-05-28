
<?php
session_start();
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header("Location: index.php");
    exit();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Incident Reporting System - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('https://media.tenor.com/-PPC-n5chR4AAAAm/seraph-of-the-end-yuu.webp') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .dashboard-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 16px;
            text-align: center;
            box-shadow: 0 6px 12px rgba(46, 109, 125, 0.3);
            max-width: 480px;
            width: 90%;
        }
        h2 {
            color:rgb(46, 60, 125);
            margin-bottom: 15px;
        }
        p {
            color: #444;
            margin-bottom: 30px;
            font-size: 1rem;
        }
        .btn-custom {
            background-color:rgb(46, 53, 125);
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            text-decoration: none;
            display: block;
            margin: 10px 0;
            transition: background-color 0.3s ease;
        }
        .btn-custom:hover {
            background-color:rgb(27, 94, 89);
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h2>Welcome, <?= htmlspecialchars($username) ?>!</h2>
        <p>You are now logged into the Incident Reporting System.</p>
        <a href="report_incident.php" class="btn-custom">Report an Incident</a>
        <a href="logout.php" class="btn-custom">Logout</a>
    </div>
</body>
</html>
