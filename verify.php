<?php
session_start();

if (!isset($_SESSION['pending_verification_email'])) {
    header("Location: register.php");
    exit();
}

$usersFile = 'users.json';
$users = file_exists($usersFile) ? json_decode(file_get_contents($usersFile), true) : [];

$errors = [];
$success = '';
$email = $_SESSION['pending_verification_email'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input_otp = trim($_POST['otp'] ?? '');

    if (!$input_otp) {
        $errors[] = "Please enter the verification code.";
    } else {
        foreach ($users as &$user) {
            if (strcasecmp($user['email'], $email) === 0) {
                if ($user['otp'] == $input_otp) {
                    $user['verified'] = true;
                    unset($user['otp']);
                    file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));
                    $success = "Your email has been verified successfully! You can now <a href='login.php'>login</a>.";
                    unset($_SESSION['pending_verification_email']);
                } else {
                    $errors[] = "Invalid verification code.";
                }
                break;
            }
        }
        unset($user);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Verify OTP</title>
<style>
/* Simple styling */
body { font-family: Arial, sans-serif; background:#f4f7f8; padding: 30px; }
.container { max-width: 400px; margin: auto; background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.15);}
h2 { margin-bottom: 20px; color: #333; }
input[type=text] {
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
    <h2>Verify Your Email</h2>

    <?php if (!empty($errors)): ?>
        <div class="error">
            <ul>
            <?php foreach ($errors as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
            </ul>
        </div>
    <?php elseif ($success): ?>
        <div class="success"><?= $success ?></div>
    <?php endif; ?>

    <?php if (!$success): ?>
    <form method="POST" action="verify_otp.php" autocomplete="off">
        <label>Enter Verification Code (OTP)</label>
        <input type="text" name="otp" required maxlength="6">

        <button type="submit">Verify</button>
    </form>
    <?php endif; ?>
</div>
</body>
</html>
