<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  http_response_code(401); // Unauthorized
  echo json_encode(["message" => "User not logged in"]);
  exit;
}

// Connecting to the database
require '../util/DB_connect.php';
$conn = connect();

// Setting headers for JSON response
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405); // Method Not Allowed
  echo json_encode(["message" => "Only POST requests are allowed"]);
  exit;
}

// Get the JSON input from the request body
$input = file_get_contents("php://input");
$new_order = json_decode($input, true);

// Check if JSON decode was successful
if (json_last_error() !== JSON_ERROR_NONE) {
  http_response_code(400);
  echo json_encode(["message" => "Invalid JSON format"]);
  exit;
}

// Check if the cart is empty
if (empty($new_order)) {
  http_response_code(400);
  echo json_encode(["message" => "Cart is empty"]);
  exit;
}

// Insert the new order into the database
$sql = "INSERT INTO orders (user_id, status, total_amount, delivery_address) VALUES (:user_id, :status, :total_amount, :delivery_address)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $new_order['user_id']);
$stmt->bindParam(':status', $new_order['status']);
$stmt->bindParam(':total_amount', $new_order['totalAmt']);
$stmt->bindParam(':delivery_address', $new_order['deliveryAddress']);

if ($stmt->execute()) {
  $orderId = $conn->lastInsertId();
  $cart = $new_order['cart'];
  error_log("Cart contents: " . print_r($cart, true));
  foreach ($cart as $item) {
    error_log("Processing item: " . print_r($item, true));
    $sql = "INSERT INTO order_products (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':order_id', $orderId);
    $stmt->bindParam(':product_id', $item['id']);
    $stmt->bindParam(':quantity', $item['quantity']);
    $stmt->bindParam(':price', $item['price']);
    if ($stmt->execute()) {
      // Return a success response
      http_response_code(201); // Created
      echo json_encode(["message" => "Cart items saved successfully", 'orderId' => $orderId]);
    } else {
      http_response_code(500); // Internal Server Error
      echo json_encode(["message" => "Failed to save order"]);
      exit;
    }
  }
} else {
  http_response_code(500); // Internal Server Error
  echo json_encode(["message" => "Failed to save order"]);
  exit;
}



// Close the database connection
$conn = null;
