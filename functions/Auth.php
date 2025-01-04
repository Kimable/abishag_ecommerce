<?php
// Middleware for checking authentication
function checkAuthentication()
{
  session_start();

  // Check if the user is logged in
  if (!isset($_SESSION['user_id'])) {
    // Save the current URL the user was trying to access
    $requestedUrl = $_SERVER['REQUEST_URI'];
    // Redirect to login page with a message and redirect parameter
    header("Location: /login.php?redirect=" . urlencode($requestedUrl) . "&message=" . urlencode("Please log in to access this page."));
    exit();
  }
}

function isAdmin()
{
  if ($_SESSION['role'] != 'admin') {
    header("Location: /user/unauthorized.php");
    exit();
  }
}
