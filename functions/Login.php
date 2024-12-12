<?php

$errorMsg = $email = $password = "";

require __DIR__ . '/../functions/TestInputs.php';
require __DIR__ . '/../util/DB_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = test_input($_POST['email']);
  $password = test_input($_POST['password']);

  $pdo = connect();

  $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->execute([$email]);
  $user = $stmt->fetch();

  if ($user && password_verify($password, $user['password'])) {
    if ($user['is_verified']) {
      session_start();
      $_SESSION['user_id'] = $user['id'];
      if ($user['role'] == 'user') {
        header("Location: /user/dashboard.php");
      } else {
        header("Location: /admin/dashboard.php");
      }
    } else {
      $errorMsg = "Please verify your email before logging in.";
    }
  } else {
    $errorMsg = "Invalid email or password.";
  }
}
