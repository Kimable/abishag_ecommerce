<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $resetCode = $_POST['reset_code'];
  $newPassword = $_POST['new_password'];

  $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
  $stmt = $pdo->prepare("UPDATE users SET password = ?, reset_code = NULL WHERE reset_code = ?");
  $stmt->execute([$hashedPassword, $resetCode]);

  if ($stmt->rowCount()) {
    echo "Password reset successful! You can now log in.";
  } else {
    echo "Invalid or expired reset link.";
  }
}
