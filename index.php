<?php
session_start();
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Incident Reporting System</title>
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
        .auth-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 16px;
            text-align: center;
            box-shadow: 0 6px 12px rgba(46, 125, 50, 0.3);
            max-width: 420px;
            width: 90%;
        }
        h1 {
            font-size: 1.8rem;
            margin-bottom: 10px;
            color: #2e7d32;
        }
        p {
            font-size: 1rem;
            color: #444;
            margin-bottom: 25px;
        }
        .auth-buttons {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .auth-btn {
            background-color: #2e7d32;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .auth-btn:hover {
            background-color: #1b5e20;
        }
        .subtext {
            font-size: 0.9rem;
            color: #666;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <h1>Incident Reporting System</h1>
        <p>Report and manage security incidents within the organization securely and efficiently.</p>
        <div class="auth-buttons">
            <a href="login.php" class="auth-btn">User Login</a>
            <a href="register.php" class="auth-btn">User Register</a>
            <a href="admin_login.php" class="auth-btn">Admin Login</a>
        </div>
        <p class="subtext">Your reports are confidential and will be handled with strict security protocols.</p>
    </div>
</body>
</html>
