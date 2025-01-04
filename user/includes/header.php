<?php
$title;
require __DIR__ . '/../../functions/Auth.php';
checkAuthentication();

if ($_SESSION['role'] == 'admin') {
  header("Location: /admin/");
  exit();
}
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
        <li><a href="/user">My Account</a></li>
        <li><a href="/about.php"></a></li>
        <li class="cart-link" id="dropdown">
          <a href="#">Products</a>
          <span class="material-symbols-outlined">keyboard_arrow_down</span>
          <!-- Dropdown content -->
          <div class="dropdown-menu">
            <a href="/products.php?category=wigs">Wigs & Weaves</a>
            <a href="/products.php?category=hair-care-styling">Hair care & Styling</a>
            <a href="/products.php?category=hair-extensions">Premium extensions</a>
            <a href="/products.php?category=hair-products">Hair Products</a>
            <a href="/products.php?category=hair-styling-tools">Hair Styling Tools</a>
            <a href="/products.php?category=hair-accessories">Hair Essentials & Accessories</a>
            <a href="/products.php?category=hair-installation-services">Installation Services</a>
            <a href="/products.php?category=hair-maintenance">Ongoing Maintenance Support</a>
          </div>
        </li>
        <li><a href="/contact.php">Contact Us</a></li>
        <li class="cart-link">
          <a href="/cart.php">Cart</a>
          <span class="material-symbols-outlined">local_mall</span>
        </li>

        <li><a href="/user/logout.php">Logout</a></li>
      </ul>
    </nav>
    <div class="menu-btn" onclick="toggleMenu()">
      <span class="material-symbols-outlined">menu</span>
    </div>
  </header>

  <nav id="navbar" class="navbar mobile-nav">
    <div class="close-btn" onclick="toggleMenu()">&times;</div>
    <ul>
      <li><a href="/user">My Account</a></li>
      <li class="cart-link" id="dropdown">
        <a href="#">Products</a>
        <span class="material-symbols-outlined">keyboard_arrow_down</span>
        <!-- Dropdown content -->
        <div class="dropdown-menu">
          <a href="/products.php?category=wigs">Wigs & Weaves</a>
          <a href="/products.php?category=hair-care-styling">Hair care & Styling</a>
          <a href="/products.php?category=hair-extensions">Premium extensions</a>
          <a href="/products.php?category=hair-products">Hair Products</a>
          <a href="/products.php?category=hair-styling-tools">Hair Styling Tools</a>
          <a href="/products.php?category=hair-accessories">Hair Essentials & Accessories</a>
          <a href="/products.php?category=hair-installation-services">Installation Services</a>
          <a href="/products.php?category=hair-maintenance">Ongoing Maintenance Support</a>
        </div>
      </li>
      <li><a href="/contact.php">Contact</a></li>
      <li class="cart-link">
        <a href="/cart.php">Cart</a>
        <span class="material-symbols-outlined">
          local_mall
        </span>
      </li>
      <li><a href="/user/logout.php">Logout</a></li>
    </ul>
  </nav>

  <div class="overlay" id="overlay" onclick="toggleMenu()"></div>

  <!-- CSS -->
  <style>
    header {
      position: sticky;
      z-index: 10000;
      top: 0;
    }

    .cart-link {
      position: relative;
      cursor: pointer;
    }

    .dropdown-menu {
      display: none;
      position: absolute;
      top: 100%;
      left: 0;
      background-color: var(--light-pink);
      color: black;
      border-radius: 13px;
      min-width: 180px;
      z-index: 1000;
    }

    .cart-link .dropdown-menu a {
      display: block;
      padding: 10px;
      text-decoration: none;
      font-size: 16px;
      color: var(--pink);
    }

    /* Show dropdown on hover */
    .cart-link:hover .dropdown-menu {
      display: block;
    }

    /* Show dropdown on click using a class */
    .cart-link.active .dropdown-menu {
      display: block;
    }

    @media (max-width:768px) {
      .dropdown-menu {
        left: 10%;
      }
    }
  </style>