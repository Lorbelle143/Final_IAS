<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$log_file = 'incident_log.txt';
$log = file_exists($log_file) ? file_get_contents($log_file) : 'No logs yet.';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Incident Log - Literal System</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .log-box {
            background: #f9f9f9;
            border: 1px solid #ccc;
            padding: 20px;
            font-family: monospace;
            white-space: pre-wrap;
            max-height: 500px;
            overflow-y: auto;
            border-radius: 8px;
        }

        .back-link {
            margin-top: 20px;
            display: inline-block;
            color: #007bff;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Incident Log (Audit Trail)</h2>

    <div class="log-box">
        <?= htmlspecialchars($log) ?>
    </div>

    <a href="dashboard.php" class="back-link">← Back to Dashboard</a>
</div>
</body>
</html>
