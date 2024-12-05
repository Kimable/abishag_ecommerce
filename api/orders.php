<?php
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
$cartItems = json_decode($input, true);

// Check if JSON decode was successful
if (json_last_error() !== JSON_ERROR_NONE) {
  http_response_code(400);
  echo json_encode(["message" => "Invalid JSON format"]);
  exit;
}

// Insert each item in the cart into the database
// foreach ($cartItems as $item) {
//   $productId = $conn->$item['product_id'];
//   $productName = $conn->$item['product_name'];
//   $quantity = (int)$item['quantity'];
//   $price = (float)$item['price'];

//   $sql = "INSERT INTO cart_items (product_id, product_name, quantity, price)
//             VALUES ('$productId', '$productName', '$quantity', '$price')";

//   if (!$conn->query($sql)) {
//     http_response_code(500); // Internal Server Error
//     echo json_encode(["message" => "Error saving item."]);
//     exit;
//   }
// }

// Close the database connection
$conn = null;

// Return a success response
http_response_code(201); // Created
echo json_encode(["message" => "Cart items saved successfully", 'cart' => $cartItems]);
