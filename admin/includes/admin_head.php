<?php
require __DIR__ . '/../../functions/Auth.php';
checkAuthentication();
isAdmin();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="/assets/images/abishag-logo.png" type="image/x-icon">
  <link rel="stylesheet" href="../../assets/css/styles.css">
  <title>Abishag Admin</title>
</head>
<style>
  body {
    display: flex;
    overflow: hidden;
  }

  .main-content {
    margin-left: 18%;
    height: 100vh;
    overflow-y: auto;
    width: 82%;
    padding: 20px;
    display: flex;
    flex-direction: column;
  }

  .content h1 {
    color: var(--dark-grey);
    margin-bottom: 1rem;
  }

  @media (max-width: 768px) {
    .main-content {
      padding: 21px 10px;
    }

    .main-content h1 {
      font-size: 1.5rem;
    }
  }
</style>

<body>
  <?php include 'includes/sidebar.php'; ?>
  <div class="main-content">
    <div class="content">