<?php
require './util/env.php';
function connect()
{
  $dbName = 'ecommerce';
  $serverName = getenv('SERVER_NAME');
  $userName = getenv('USER_NAME');
  $password = getenv("PASS");
  try {
    $conn = new PDO("mysql:host=$serverName;dbname=$dbName", $userName, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conn;
  } catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }
}
