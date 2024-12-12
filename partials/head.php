<?php
$title;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="/assets/images/abishag-logo.png" type="image/x-icon">
  <link rel="stylesheet" href="/assets/css/styles.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <title><?php echo "Abishag Ecommerce - " . $title ?></title>
</head>

<body>

  <header>

    <a href="/" class="logo"><img src="../assets/images/abishag-logo.png" alt="Logo"></a>
    <!-- Navbar for large screens -->
    <nav class="desktop-nav">
      <ul>
        <li><a href="/">Home</a></li>
        <li><a href="/about.php">About Us</a></li>
        <li><a href="/products.php">Products</a></li>
        <li><a href="/contact.php">Contact Us</a></li>
        <li class="cart-link">
          <a href="/cart.php">Cart</a>
          <span class="material-symbols-outlined">
            local_mall
          </span>
        </li>
      </ul>
    </nav>
    <div class="menu-btn" onclick="toggleMenu()">
      <span class="material-symbols-outlined">
        menu
      </span>
    </div>
  </header>

  <nav id="navbar" class="navbar">
    <div class="close-btn" onclick="toggleMenu()">&times;</div>
    <ul>
      <li><a href="/">Home</a></li>
      <li><a href="/about.php">About</a></li>
      <li><a href="/products.php">Products</a></li>
      <li><a href="/contact.php">Contact</a></li>
      <li class="cart-link">
        <a href="/cart.php">Cart</a>
        <span class="material-symbols-outlined">
          local_mall
        </span>
      </li>
    </ul>
  </nav>

  <div class="overlay" id="overlay" onclick="toggleMenu()"></div>