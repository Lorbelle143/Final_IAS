<?php
session_start();
require 'config.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: index.php");
    exit();
}

$result = $conn->query("SELECT * FROM incidents ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>View Incidents - Incident Reporting System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('https://media.tenor.com/-PPC-n5chR4AAAAm/seraph-of-the-end-yuu.webp') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            padding: 30px;
            display: flex;
            align-items: flex-start;
            justify-content: center;
        }
        .auth-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 6px 12px rgba(46, 125, 50, 0.3);
            max-width: 1100px;
            width: 100%;
        }
        h2 {
            color: #2e7d32;
            text-align: center;
            margin-bottom: 25px;
        }
        .table th {
            background-color: #2e7d32;
            color: white;
        }
        .btn-back {
            background-color: #2e7d32;
            color: white;
            margin-bottom: 20px;
        }
        .btn-back:hover {
            background-color: #1b5e20;
        }
        .table td, .table th {
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <h2>Incident Reporting System - Submitted Reports</h2>
        <a href="admin_dashboard.php" class="btn btn-back">← Back to Admin Dashboard</a>

        <?php if ($result && $result->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Reported At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($incident = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($incident['id']) ?></td>
                                <td><?= htmlspecialchars($incident['fullname']) ?></td>
                                <td><?= htmlspecialchars($incident['email']) ?></td>
                                <td><?= htmlspecialchars($incident['phone']) ?></td>
                                <td><?= htmlspecialchars($incident['title']) ?></td>
                                <td><?= nl2br(htmlspecialchars($incident['description'])) ?></td>
                                <td><?= htmlspecialchars($incident['created_at']) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-danger text-center">No incidents reported yet.</p>
        <?php endif; ?>
    </div>
</body>
</html>
