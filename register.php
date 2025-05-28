<?php
session_start();
date_default_timezone_set('Asia/Manila');
require 'config.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';
require 'src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email    = $_POST['email'];
    $password = $_POST['password'];
    $captcha  = $_POST['captcha'];

    if ($captcha != $_SESSION['captcha_result']) {
        echo "<div class='text-danger text-center mt-2'>Incorrect CAPTCHA result.</div>";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $otp = rand(100000, 999999);
        $otp_expiry = (new DateTime())->modify('+10 minutes')->format("Y-m-d H:i:s");

        $stmt = $conn->prepare("INSERT INTO user (username, email, password, otp, otp_expiry) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username, $email, $hashed_password, $otp, $otp_expiry);

        if ($stmt->execute()) {
            try {
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'lorbelleganzan@gmail.com'; // your Gmail address
                $mail->Password = 'njeq vgnh ciwy zuwy';      // your Gmail App Password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = 465;

                // This block fixes SSL certificate verify error in local environments
                $mail->SMTPOptions = [
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true,
                    ],
                ];

                $mail->setFrom('lorbelleganzan@gmail.com', 'Your System');
                $mail->addAddress($email);
                $mail->Subject = 'Verify Your Email - OTP Code';
                $mail->Body = "Hello $username,\n\nYour OTP code is: $otp\nThis will expire in 10 minutes.\n\nThank you!";

                $mail->send();
                header("Location: verify_otp.php?email=" . urlencode($email));
                exit();
            } catch (Exception $e) {
                echo "<div class='text-danger text-center mt-2'>OTP Email failed: {$mail->ErrorInfo}</div>";
            }
        } else {
            echo "<div class='text-danger text-center mt-2'>Registration failed. Try again.</div>";
        }
    }
}

$num1 = rand(1, 9);
$num2 = rand(1, 9);
$_SESSION['captcha_result'] = $num1 + $num2;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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

        .register-box {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px 40px;
            border-radius: 16px;
            box-shadow: 0 6px 12px rgba(46, 125, 50, 0.3);
            width: 100%;
            max-width: 500px;
        }

        .register-box h3 {
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
    <div class="register-box">
        <h3 class="text-center">Register</h3>
        <form method="POST">
            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>What is <?= $num1 ?> + <?= $num2 ?>?</label>
                <input type="number" name="captcha" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-green w-100">Register & Send OTP</button>
        </form>
    </div>
</body>
</html>
