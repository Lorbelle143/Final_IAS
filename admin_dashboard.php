<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Admin Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<style>
    body {
        background: url('https://media.tenor.com/-PPC-n5chR4AAAAm/seraph-of-the-end-yuu.webp') no-repeat center center fixed;
        background-size: cover;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .dashboard {
        background: rgba(255, 255, 255, 0.95);
        color: #2e7d32;
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 6px 12px rgba(46, 125, 50, 0.3);
        text-align: center;
        width: 100%;
        max-width: 500px;
    }

    .dashboard h1 {
        margin-bottom: 25px;
        font-weight: bold;
    }

    .btn-green {
        background-color: #2e7d32;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 10px;
        text-decoration: none;
        display: inline-block;
        margin: 10px 0;
        width: 100%;
        font-size: 16px;
        transition: background-color 0.3s ease;
    }

    .btn-green:hover {
        background-color: #1b5e20;
    }
</style>
</head>
<body>
    <div class="dashboard">
        <h1>Welcome Admin: <?= htmlspecialchars($_SESSION['admin_username']) ?></h1>
        <a href="view_incidents.php" class="btn-green">View All Incidents</a>
        <a href="logout.php" class="btn-green">Logout</a>
    </div>
</body>
</html>
