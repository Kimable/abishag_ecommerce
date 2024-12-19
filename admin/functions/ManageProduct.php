<?php
require __DIR__ . '/../../util/DB_connect.php';
require  __DIR__ .  '/../../functions/TestInputs.php';
require  __DIR__ .  "/../../functions/GenerateSlug.php";


function addProduct()
{
  $productName = $price = $offer_price = $quantity = $status = $message = $description = '';

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
      $status = 'err';
    }
    if (empty($price)) {
      $message = "Price is required";
      $status = 'err';
    }
    if (empty($quantity)) {
      $message = "Product quantity is required";
      $status = 'err';
    }

    // Connect to DB
    $conn = connect();

    // Generate slug based on product name
    $slug = generateSlug($productName);

    // Check if product name exists
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
      $uploadDirectory = '/' . 'uploads/';
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
          if (move_uploaded_file($tmpName, __DIR__ . '/../..' . $filePath)) {
            // Save image path and main flag in the database
            $stmt = $conn->prepare("INSERT INTO product_images (product_id, image_path) VALUES (:product_id, :image_path)");
            $stmt->execute([
              ':product_id' => $productId,
              ':image_path' => $filePath,
            ]);
          } else {
            $message = "Failed to upload file: $originalName<br>";
            $status = 'err';
          }
        } else {
          $message = "Invalid file type: $originalName (only JPEG, PNG, WEBP, and GIF allowed).";
          $status = 'err';
        }
      }
      $successMsg = "Product added successfully";
      return ['message' => $successMsg, 'status' => 'ok', 'id' => $productId, 'productName' => $productName, 'price' => $price, 'offer_price' => $offer_price, 'quantity' => $quantity, 'description' => $description];
    } else {
      $message = "This product already exists";
      $status = 'err';
    }
  }
  $conn = null;
  return ['message' => $message, 'status' => $status, 'productName' => $productName, 'price' => $price, 'offer_price' => $offer_price, 'quantity' => $quantity, 'description' => $description];
}
function updateProduct() {}
function deleteProduct()
{
  if (isset($_POST['delete'])) {
    $productId = $_POST['id'];
    $conn = connect();
    try {
      $stmt = $conn->prepare("DELETE FROM products WHERE id =?");
      if ($stmt->execute([$productId])) {
        header('Location: /admin/manage-products.php');
      } else {
        return "Something Went wrong";
      }
    } catch (Exception $e) {
      $message =  $e->getMessage();
      return $message;
    }
  }
}
function archiveProduct()
{
  if (isset($_POST['archive'])) {
    $productId = $_POST['id'];
    $conn = connect();
    try {
      $stmt = $conn->prepare("UPDATE products SET archive = 1 WHERE id =?");
      if ($stmt->execute([$productId])) {
        header('Location: /admin/manage-products.php');
      } else {
        return "Something Went wrong";
      }
    } catch (Exception $e) {
      $message =  $e->getMessage();
      return $message;
    }
  }
}
function markOutOfStock() {}
function updateProductImages() {}
