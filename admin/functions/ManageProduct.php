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
function updateProduct()
{
  $productName = $price = $offer_price = $quantity = $message = $description = '';
  if (isset($_POST['update'])) {
    $productName = test_input($_POST['productName']);
    $price = test_input($_POST['price']);
    $offer_price = test_input($_POST['offer_price']);
    $quantity = test_input($_POST['quantity']);
    $description = test_input($_POST['description']);
    $category = test_input($_POST['category']);
    $tag = test_input($_POST['tag']);
    $productId = test_input($_POST['id']);

    // Connect to DB
    $conn = connect();

    // Generate slug based on product name
    $slug = generateSlug($productName);

    // Check if product exists
    $prod = $conn->prepare("SELECT * FROM products WHERE id =?");
    $prod->execute([$productId]);
    $product = $prod->fetch();

    if ($product) {
      $stmt = $conn->prepare("UPDATE products SET name = :name, description = :description, price = :price, quantity = :quantity, offer_price = :offer_price, slug = :slug, category = :category, tag = :tag WHERE id = :id");

      $stmt->execute([
        ':name' => $productName,
        ':description' => $description,
        ':price' => $price,
        ':quantity' => $quantity,
        ':offer_price' => $offer_price,
        ':slug' => $slug,
        ':category' => $category,
        ':tag' => $tag,
        ':id' => $productId
      ]);
      $successMsg = "Product updated successfully";
      header("Location: /admin/product.php?slug=$slug&prod_id=$productId&status=ok&message=$successMsg");
      return;
    } else {
      $message = "Product not found";
      header("Location: /admin/product.php?slug=$slug&prod_id=$productId&status=err&message=$message");
    }
  }
}
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
function updateMainImage()
{
  if (isset($_POST['mainImg'])) {
    $imgId = $_POST['id'];
    $productId = $_POST['product_id'];
    $conn = connect();

    // Set all images to not main
    $stmt = $conn->prepare("UPDATE product_images SET main = 0 WHERE product_id =?");
    $stmt->execute([$productId]);

    try {
      $stmt = $conn->prepare("UPDATE product_images SET main = 1 WHERE id =?");
      if ($stmt->execute([$imgId])) {
        $successMsg = "Main Image Updated Successfully";
        header("Location: /admin/product.php?slug=&prod_id=$productId&status=ok&message=$successMsg");
      } else {
        $errorMsg = "Something Went wrong. Try again";
        header("Location: /admin/product.php?slug=''&prod_id=$productId&status=err&message=$errorMsg");
      }
    } catch (Exception $e) {
      $message =  $e->getMessage();
      header("Location: /admin/product.php?slug=''&prod_id=$productId&status=err&message=$message");
    }
  }
}

function deleteProductImage()
{
  if (isset($_POST['deleteImg'])) {
    $imgId = $_POST['id'];
    $productId = $_POST['product_id'];
    $conn = connect();
    //Can't delete main image
    $stmt = $conn->prepare("SELECT * FROM product_images WHERE id =? AND main = 1");
    $stmt->execute([$imgId]);
    $mainImage = $stmt->fetch();
    if ($mainImage) {
      $errorMsg = "Can't delete main image. Set another image as main first";
      header("Location: /admin/product.php?slug=''&prod_id=$productId&status=err&message=$errorMsg");
      return;
    }
    try {
      $stmt = $conn->prepare("DELETE FROM product_images WHERE id =?");
      if ($stmt->execute([$imgId])) {
        $successMsg = "Image Deleted Successfully";
        header("Location: /admin/product.php?slug=&prod_id=$productId&status=ok&message=$successMsg");
      } else {
        $errorMsg = "Something Went wrong. Try again";
        header("Location: /admin/product.php?slug=''&prod_id=$productId&status=err&message=$errorMsg");
      }
    } catch (Exception $e) {
      $message =  $e->getMessage();
      header("Location: /admin/product.php?slug=''&prod_id=$productId&status=err&message=$message");
    }
  }
}

function addImages()
{
  if (isset($_FILES['images'])) {
    $productId = $_POST['product_id'];
    $conn = connect();
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $uploadDirectory = '/' . 'uploads/';
    foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
      $originalName = $_FILES['images']['name'][$key];
      $fileType = mime_content_type($tmpName); // Get MIME type
      $fileSize = $_FILES['images']['size'][$key];

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
          header("Location: /admin/product.php?slug=&prod_id=$productId&status=err&message=$message");
        }
      } else {
        $message = "Invalid file type: $originalName (only JPEG, PNG, WEBP, and GIF allowed).";
        header("Location: /admin/product.php?slug=&prod_id=$productId&status=err&message=$message");
      }
    }
    $successMsg = "Images added successfully";
    header("Location: /admin/product.php?slug=&prod_id=$productId&status=ok&message=$successMsg");
  }
}
