<?php
session_start();
date_default_timezone_set('Asia/Manila');
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $otp = trim($_POST['otp']);

    // Validate email and OTP
    $stmt = $conn->prepare("SELECT * FROM user WHERE email = ? AND otp = ?");
    $stmt->bind_param("ss", $email, $otp);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Check OTP expiry
        if (strtotime($user['otp_expiry']) >= time()) {
            // OTP is valid and not expired
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['user_logged_in'] = true;

            // Clear OTP after successful verification
            $clear = $conn->prepare("UPDATE user SET otp = NULL, otp_expiry = NULL WHERE email = ?");
            $clear->bind_param("s", $email);
            $clear->execute();

            // ✅ Redirect to login page instead of dashboard
            header("Location: login.php?verified=1");
            exit();
        } else {
            $error = "OTP has expired.";
        }
    } else {
        $error = "Invalid OTP or email not found.";
    }
}

// If email came via URL from registration
$email = $_GET['email'] ?? ($_POST['email'] ?? '');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify OTP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background:#f8f9fa;">
    <div class="container mt-5">
        <div class="col-md-6 offset-md-3 bg-white p-4 rounded shadow-sm">
            <h4 class="mb-3 text-center">Verify OTP</h4>
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($email) ?>" required>
                </div>
                <div class="mb-3">
                    <label>Enter OTP</label>
                    <input type="text" name="otp" class="form-control" required>
                </div>
                <button class="btn btn-success w-100">Verify</button>
            </form>
        </div>
    </div>
</body>
</html>
