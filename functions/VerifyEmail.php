<?php
if (isset($_GET['code'])) {
  $verificationCode = $_GET['code'];

  $stmt = $pdo->prepare("UPDATE users SET is_verified = 1 WHERE verification_code = ?");
  $stmt->execute([$verificationCode]);

  if ($stmt->rowCount()) {
    echo "Email verified successfully! You can now log in.";
  } else {
    echo "Invalid verification link.";
  }
}
