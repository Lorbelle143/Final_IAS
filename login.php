<?php
session_start();

$usersFile = 'users.json';
$users = file_exists($usersFile) ? json_decode(file_get_contents($usersFile), true) : [];

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$username || !$password) {
        $errors[] = "Both fields are required.";
    } else {
        $foundUser = null;
        foreach ($users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                $foundUser = $user;
                break;
            }
        }

        if (!$foundUser) {
            $errors[] = "Invalid username or password.";
        } elseif (!password_verify($password, $foundUser['password'])) {
            $errors[] = "Invalid username or password.";
        } elseif (empty($foundUser['verified']) || $foundUser['verified'] === false) {
            $errors[] = "Please verify your email before logging in.";
        } else {
            $_SESSION['user'] = [
                'username' => $foundUser['username'],
                'email' => $foundUser['email'],
            ];
            header("Location: incident_submit.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>User Login</title>
<style>
/* Keep previous styles */
body { font-family: Arial, sans-serif; background:#f4f7f8; padding: 30px; }
.container { max-width: 400px; margin: auto; background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.15);}
h2 { margin-bottom: 20px; color: #333; }
input[type=text], input[type=password] {
    width: 100%; padding: 10px; margin: 8px 0; border-radius: 5px; border: 1px solid #ccc;
    box-sizing: border-box;
}
button {
    background-color: #007bff; color: white; padding: 10px; border: none; border-radius: 5px; cursor: pointer;
    width: 100%; font-size: 16px;
}
button:hover { background-color: #0056b3; }
.error { color: red; margin-bottom: 15px; }
a { color: #007bff; text-decoration: none; }
a:hover { text-decoration: underline; }
</style>
</head>
<body>
<div class="container">
    <h2>User Login</h2>

    <?php if (!empty($errors)): ?>
        <div class="error">
            <ul>
            <?php foreach ($errors as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="login.php" autocomplete="off">
        <label>Username</label>
        <input type="text" name="username" required value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit">Login</button>
    </form>

    <p>Don't have an account? <a href="register.php">Register here</a></p>
</div>
</body>
</html>
