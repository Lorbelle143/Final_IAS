<?php
session_start();
require 'config.php';

// Check user is logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header("Location: index.php");
    exit();
}

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fullname = trim($_POST['fullname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if ($fullname === '' || $email === '' || $phone === '' || $title === '' || $description === '') {
        $error = "Please fill in all fields.";
    } else {
        // Insert incident report to DB
        $stmt = $conn->prepare("INSERT INTO incidents (user_id, fullname, email, phone, title, description) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $_SESSION['user_id'], $fullname, $email, $phone, $title, $description);
        if ($stmt->execute()) {
            $success = "Incident reported successfully!";
        } else {
            $error = "Failed to submit incident. Try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Report Incident</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f1f8f5;
            font-family: Arial, sans-serif;
            padding: 50px;
        }
        .form-container {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 100, 0, 0.15);
        }
        h2 {
            color: #2e7d32;
            margin-bottom: 25px;
            text-align: center;
        }
        .btn-submit {
            background-color: #2e7d32;
            color: white;
        }
        .btn-submit:hover {
            background-color: #1b5e20;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Report Incident</h2>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label for="fullname" class="form-label">Full Name</label>
                <input type="text" id="fullname" name="fullname" class="form-control" required />
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" id="email" name="email" class="form-control" required />
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="text" id="phone" name="phone" class="form-control" required />
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">Incident Title</label>
                <input type="text" id="title" name="title" class="form-control" required />
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description" rows="5" class="form-control" required></textarea>
            </div>
            <button type="submit" class="btn btn-submit w-100">Submit Report</button>
        </form>
        <br>
        <a href="dashboard.php" class="btn btn-secondary w-100">Back to Dashboard</a>
    </div>
</body>
</html>
