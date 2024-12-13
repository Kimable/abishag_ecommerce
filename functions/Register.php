<?php
require __DIR__ . '/../functions/TestInputs.php';
require __DIR__ . '/../util/DB_connect.php';
$errorMsg = $successMsg = $name = $confirmPassword = $email = $password = "";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = test_input($_POST['name']);
  $email = test_input($_POST['email']);
  $password = test_input($_POST['password']);
  $confirmPassword = test_input($_POST['confirmPassword']);

  if ($password !== $confirmPassword) {
    $errorMsg = 'Passwords do not match!';
    return;
  }

  try {
    $pdo = connect();

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (!$user) {
      $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
      $verificationCode = bin2hex(random_bytes(16));

      $stmt = $pdo->prepare("INSERT INTO users (name, email, password, verification_code) VALUES (?, ?, ?, ?)");
      $stmt->execute([$name, $email, $hashedPassword, $verificationCode]);

      $verificationLink = "http://example.com/verify.php?code=$verificationCode";
      //mail($email, "Verify Your Email", "Click here to verify your email: $verificationLink");

      $successMsg = "Registration successful! Check your email for the verification link.";
    } else {
      $errorMsg = "This Email is already registered. Login please.";
    }
  } catch (\Throwable $th) {
    $errorMsg = "Error: $th->message";
  }
}
