<?php
$request = $_SERVER['REQUEST_URI'];

switch ($request) {
  case '':
  case '/':
    require 'home.php';
    break;

  case '/products':
    require 'products.php';
    break;

  case '/product':
    require 'product.php';
    break;

  case '/cart':
    require  'cart.php';
    break;

  default:
    http_response_code(404);
    require '404.php';
}
