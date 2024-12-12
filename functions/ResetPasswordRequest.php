<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];

  $resetCode = bin2hex(random_bytes(16));
  $stmt = $pdo->prepare("UPDATE users SET reset_code = ? WHERE email = ?");
  $stmt->execute([$resetCode, $email]);

  $resetLink = "http://example.com/reset_password.php?code=$resetCode";
  mail($email, "Reset Your Password", "Click here to reset your password: $resetLink");

  echo "Password reset email sent. Check your inbox.";
}
