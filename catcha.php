<?php
session_start();
require 'config.php';

if ($_POST['captcha'] != $_SESSION['captcha']) {
    die("Captcha incorrect.");
}

$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$token = bin2hex(random_bytes(16));

$stmt = $mysqli->prepare("INSERT INTO users (email, password, token) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $email, $password, $token);
$stmt->execute();

$verifyLink = "http://localhost/auth-system/verify.php?email=$email&token=$token";
mail($email, "Verify your email", "Click here to verify: $verifyLink");

echo "Verification email sent!";
