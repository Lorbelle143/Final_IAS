<?php
session_start();
date_default_timezone_set('Asia/Manila');
require 'config.php';

$error = '';  // Add this to display errors properly in HTML

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usernameOrEmail = trim($_POST['username'] ?? '');  // trim to avoid whitespace issues
    $password = $_POST['password'] ?? '';

    if (empty($usernameOrEmail) || empty($password)) {
        $error = "Please enter both username/email and password.";
    } else {
        // Lowercase for case-insensitive match (optional but recommended)
        $usernameOrEmailLower = strtolower($usernameOrEmail);

        // Modify query to use LOWER() on database fields for case-insensitive check
        $stmt = $conn->prepare("SELECT id, username, email, password FROM user WHERE LOWER(email) = ? OR LOWER(username) = ?");
        if (!$stmt) {
            $error = "Database error: " . $conn->error;
        } else {
            $stmt->bind_param("ss", $usernameOrEmailLower, $usernameOrEmailLower);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();

                if (password_verify($password, $user['password'])) {
                    // Set session variables
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['user_logged_in'] = true; // Important!

                    header("Location: dashboard.php");
                    exit();
                } else {
                    $error = "Invalid password.";
                }
            } else {
                $error = "User not found.";
                error_log("Login failed: user not found for input: $usernameOrEmail");
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Login</title>
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
        .login-box {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px 40px;
            border-radius: 16px;
            box-shadow: 0 6px 12px rgba(46, 125, 50, 0.3);
            width: 100%;
            max-width: 400px;
        }
        .login-box h3 {
            color: #2e7d32;
            margin-bottom: 25px;
        }
        .btn-green {
            background-color: #2e7d32;
            color: white;
        }
        .btn-green:hover {
            background-color: #1b5e20;
        }
        label {
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h3 class="text-center">Login</h3>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label>Username or Email</label>
                <input type="text" name="username" class="form-control" required />
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required />
            </div>
            <button class="btn btn-green w-100" type="submit">Login</button>
        </form>
    </div>
</body>
</html>
