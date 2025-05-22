<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

$usersFile = 'users.json';
$users = file_exists($usersFile) ? json_decode(file_get_contents($usersFile), true) : [];

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';

    // Validate inputs
    if (!$username || !$email || !$password || !$confirm) {
        $errors[] = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    } elseif ($password !== $confirm) {
        $errors[] = "Passwords do not match.";
    } else {
        // Check duplicate username/email
        foreach ($users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                $errors[] = "Username already taken.";
                break;
            }
            if (strcasecmp($user['email'], $email) === 0) {
                $errors[] = "Email already registered.";
                break;
            }
        }
    }

    if (empty($errors)) {
        $otp = rand(100000, 999999);  // Generate 6-digit OTP

        // Add new user
        $users[] = [
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'verified' => false,
            'otp' => $otp,
        ];
        file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));

        // Prepare email
        $subject = "Your Verification Code";
        $message = "Hello $username,\n\nYour verification code is: $otp\n\nThank you!";
        $headers = "From: no-reply@example.com";

        // Try to send mail
        if (mail($email, $subject, $message, $headers)) {
            $_SESSION['pending_verification_email'] = $email;  // Save for verification step
            header("Location: verify.php");
            exit();
        } else {
            // For localhost/testing: store OTP in session so user can verify manually
            $_SESSION['pending_verification_email'] = $email;
            $_SESSION['otp'] = $otp;
            header("Location: verify.php?test=1");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>User Registration</title>
<style>
body { font-family: Arial, sans-serif; background:#f4f7f8; padding: 30px; }
.container { max-width: 400px; margin: auto; background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.15);}
h2 { margin-bottom: 20px; color: #333; }
input[type=text], input[type=email], input[type=password] {
    width: 100%; padding: 10px; margin: 8px 0; border-radius: 5px; border: 1px solid #ccc;
    box-sizing: border-box;
}
button {
    background-color: #007bff; color: white; padding: 10px; border: none; border-radius: 5px; cursor: pointer;
    width: 100%; font-size: 16px;
}
button:hover { background-color: #0056b3; }
.error { color: red; margin-bottom: 15px; }
.success { color: green; margin-bottom: 15px; }
a { color: #007bff; text-decoration: none; }
a:hover { text-decoration: underline; }
</style>
</head>
<body>
<div class="container">
    <h2>User Registration</h2>

    <?php if (!empty($errors)): ?>
        <div class="error">
            <ul>
            <?php foreach ($errors as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
            </ul>
        </div>
    <?php elseif ($success): ?>
        <div class="success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="POST" action="register.php" autocomplete="off">
        <label>Username</label>
        <input type="text" name="username" required value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">

        <label>Email</label>
        <input type="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">

        <label>Password</label>
        <input type="password" name="password" required>

        <label>Confirm Password</label>
        <input type="password" name="confirm" required>

        <button type="submit">Register</button>
    </form>

    <p>Already have an account? <a href="login.php">Login here</a></p>
</div>
</body>
</html>
