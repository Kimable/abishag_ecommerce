<?php
$errorMsg = $email = $password = $redirect = "";

require __DIR__ . '/../functions/TestInputs.php';
require __DIR__ . '/../util/DB_connect.php';

// Retrieve the message and redirect parameters
$message = isset($_GET['message']) ? $_GET['message'] : null;
$redirect = isset($_GET['redirect']) ? $_GET['redirect'] : null;

// Display error message if available
if ($message) {
  $errorMsg = $message;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = test_input($_POST['email']);
  $password = test_input($_POST['password']);
  $redirect = isset($_POST['redirect']) ? $_POST['redirect'] : null;
  $pdo = connect();

  // Check user credentials
  $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->execute([$email]);
  $user = $stmt->fetch();

  if ($user && password_verify($password, $user['password'])) {
    if ($user['is_verified']) {
      session_start();

      $_SESSION['user_id'] = $user['id'];
      $_SESSION['role'] = $user['role'];
      // Redirect based on role
      if ($redirect) {
        header("Location: " . $redirect);
        exit();
      }

      if ($user['role'] == 'admin') {
        header("Location: /admin");
      } else {
        header("Location: /user/dashboard.php");
      }
      exit();
    } else {
      $errorMsg = "Please verify your email before logging in.";
    }
  } else {
    $errorMsg = "Invalid email or password.";
  }
}
