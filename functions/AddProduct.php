<?php
require './util/DB_connect.php';
require './functions/TestInputs.php';
$productName = $price = $description = $image = $quantity = $category = $tag = $offer_price = $message = $successMsg = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $productName = test_input($_POST['productName']);
  $price = test_input($_POST['price']);
  $offer_price = test_input($_POST['offer_price']);
  $quantity = test_input($_POST['quantity']);
  $description = test_input($_POST['description']);
  $category = test_input($_POST['category']);
  $tag = test_input($_POST['tag']);

  if (empty($productName)) {
    $message = "Product name is required";
    return;
  }
  if (empty($price)) {
    $message = "Price is required";
    return;
  }
  if (empty($quantity)) {
    $message = "Product quantity is required";
    return;
  }

  // Connect to DB
  $conn = connect();

  // Generate slug based on product name
  $lowerCaseProductName = strtolower($productName);
  $slug = str_replace(' ', "-", $lowerCaseProductName);


  // Check if product Name exists
  $prod = $conn->prepare("SELECT * FROM products WHERE slug=?");
  $prod->execute([$slug]);
  $product = $prod->fetch();

  if (!$product) {
    $stmt = $conn->prepare("INSERT INTO products (name, description, price, quantity, offer_price, slug, category, tag) VALUES(:name, :description, :price, :quantity, :offer_price, :slug, :category, :tag)");

    $stmt->execute([
      ':name' => $productName,
      ':description' => $description,
      ':price' => $price,
      ':quantity' => $quantity,
      ':offer_price' => $offer_price,
      ':slug' => $slug,
      ':category' => $category,
      ':tag' => $tag
    ]);

    $productId = $conn->lastInsertId();

    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

    // Handle image uploads
    $uploadDirectory = './' . 'uploads/';
    foreach ($_FILES['product_images']['tmp_name'] as $key => $tmpName) {
      $originalName = $_FILES['product_images']['name'][$key];
      $fileType = mime_content_type($tmpName); // Get MIME type
      $fileSize = $_FILES['product_images']['size'][$key];

      // Check if the file is an image
      if (in_array($fileType, $allowedTypes)) {
        // Rename the file
        $extension = pathinfo($originalName, PATHINFO_EXTENSION); // Extract file extension
        $newFileName = uniqid('img_', true) . '.' . $extension;   // Unique file name
        $filePath = $uploadDirectory . $newFileName;

        // Move the file to the upload directory
        if (move_uploaded_file($tmpName, $filePath)) {
          // Save image path in the database
          $stmt = $conn->prepare("INSERT INTO product_images (product_id, image_path) VALUES (:product_id, :image_path)");
          $stmt->execute([
            ':product_id' => $productId,
            ':image_path' => $filePath
          ]);
        } else {
          $message = "Failed to upload file: $originalName<br>";
        }
      } else {
        $message = "Invalid file type: $originalName (only JPEG, PNG, and GIF allowed).<br>";
      }
    }

    $successMsg = "Product added successfully";
  } else {
    $message = "This product already exists";
  }
}
