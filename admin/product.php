<?php
require './functions/ManageProduct.php';
updateProduct();
$deleteMsg = deleteProduct();
updateMainImage();
archiveProduct();
deleteProductImage();
addImages();


// Get the item slug or id from the URL query string
$errorMsg = '';
$product = null;
if (isset($_GET['slug'])) {
  $slug = $_GET['slug'];
  $prod_id = $_GET['prod_id'];
  // Fetch the item details from the database
  $conn = connect();
  $sql = "SELECT * FROM products WHERE slug = :slug OR id = :prod_id";
  $stmt = $conn->prepare($sql);
  $stmt->execute([':slug' => $slug, ':prod_id' => $prod_id]);
  $product = $stmt->fetch(PDO::FETCH_ASSOC);

  // var_dump($product);
  if (!$product) {
    $errorMsg = "Product not found!";
  } else {
    $productId = $product['id'];
    // Fetch the associated images
    $stmt = $conn->prepare("SELECT * FROM product_images WHERE product_id = :product_id");
    $stmt->execute([':product_id' => $productId]);
    $images = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}

require  './includes/admin_head.php';
?>

<style>
  @import url('/assets/css/admin/single_product.css');
</style>

<h1>Manage Product</h1>

<!-- Messages -->
<?php if ($deleteMsg) { ?>
  <p class="error"><?= $deleteMsg ?></p>
<?php } ?>
<?php if ($_GET['status'] == 'ok' && $_GET['message'] != ''): ?>
  <p class="success"><?= $_GET['message'] ?></p>
<?php endif ?>
<?php if ($_GET['status'] != 'ok' && $_GET['message'] != ''): ?>
  <p class="error"><?= $_GET['message'] ?></p>
<?php endif ?>


<div class="manage-single-product">
  <?php if (!$product) { ?>
    <h2 class="danger">Product NOT Found</h2>
    <p>That product doesn't exist because it either was deleted or you've entered invalid details.</p>
    <a href="/admin/manage-products.php" class="btn">Choose Another Product to Manages</a>
  <?php } else { ?>
    <div class="product-detail">
      <h3>Product Images</h3>
      <div id="images">
        <?php foreach ($images as $img): ?>
          <div class="img-cont">
            <img id="thumbnail" src="<?= $img['image_path'] ?>" alt="<?= $product['name'] . " " . $img['id'] ?>" onclick="openModal(this)">
            <div>
              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <input type="hidden" name="id" value="<?= htmlspecialchars($img['id']) ?>">
                <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">
                <button name="mainImg" class="main-btn" type="submit">Main</button>
              </form>
              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <input type="hidden" name="id" value="<?= htmlspecialchars($img['id']) ?>">
                <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">
                <button name="deleteImg" class="remove-btn" type="submit">
                  <img width="20px" src="/assets/images/icons/delete.png" alt="">
                </button>
              </form>
            </div>
          </div>
        <?php endforeach ?>
        <!-- Add Images -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data" id="uploadForm">
          <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">
          <label for="imgs" class="custom-file-upload">
            <small>Add Images</small> <br><img width="35px" src="/assets/images/icons/add_a_photo.png" alt="Upload">
          </label>
          <input type="file" name="images[]" id="imgs" multiple accept="image/*" class="file-upload">
          <div id="fileList"></div>
        </form>
      </div>

      <!-- Product Details -->
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="details-form">
        <h3>Product Details</h3>
        <input type="hidden" name="id" value="<?= htmlspecialchars($product['id']) ?>">
        <div class="input-container">
          <label>Product Name:</label>
          <input type="text" name='productName' id="productName" value="<?= $product['name'] ?>" class="highlight">
        </div>

        <div class="input-container">
          <label for="price">Product Price:</label>
          <input type="text" name='price' id="price" value="<?= (int) $product['price'] ?>" class="highlight">
        </div>

        <div class="input-container">
          <label for="quantity">Product Quantity:</label>
          <input type="text" name='quantity' id="quantity" value="<?= $product['quantity'] ?>" class="highlight">
        </div>

        <div class="input-container">
          <label>Offer Price:</label>
          <input type="text" name='offer_price' id="offer_price" value="<?= (int) $product['offer_price'] ?>" class="highlight">
        </div>

        <div class="input-container">
          <label for="category">Product Category</label>
          <select name="category" id="category">
            <option value="<?= htmlspecialchars($product['category']) ?>" selected><?= htmlspecialchars($product['category']) ?></option>
            <option value="hair-extensions">Hair Extensions</option>
            <option value="hair-products">Hair Care Products</option>
            <option value="wigs">Wigs & Weaves</option>
            <option value="hair-styling-tools">Hair Styling Tools</option>
            <option value="hair-accessories">Hair Essentials and Accessories</option>
            <option value="hair-care-styling">Hair care & Styling</option>
            <option value="hair-installation-services">Hair Installation Services</option>
            <option value="hair-maintenance">Ongoing Maintenance Support</option>
          </select>
        </div>

        <div class="input-container">
          <label for="tag">Product Tag</label>
          <select name="tag" id="tag">
            <option value="<?= htmlspecialchars($product['tag']) ?>" selected><?= htmlspecialchars($product['tag']) ?></option>
            <option value="offer">Offer</option>
            <option value="free-delivery">Free Delivery</option>
            <option value="5-off">5% Off</option>
            <option value="10-off">10% Off</option>
            <option value="15-off">15% Off</option>
            <option value="20-off">20% Off</option>
            <option value="25-off">25% Off</option>
            <option value="30-off">30% Off</option>
            <option value="40-off">40% Off</option>
            <option value="50-off">50% Off</option>
          </select>
        </div>

        <div class="input-container">
          <label>Product Description:</label>
          <textarea class="highlight" name="description" id="description" rows="6" cols="30"><?= $product['description'] ?></textarea>
        </div>
        <button class="btn" type="submit" name="update">Save Changes</button>
      </form>

      <!-- Danger -->
      <div class="danger-zone">
        <h3>Danger Zone</h3>
        <p>Careful, product once deleted cannot be recovered.</p>
        <p>If you want to use this product in the future, you may wish to archive it instead.</p>
        <div>
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="hidden" name="id" value="<?= htmlspecialchars($product['id']) ?>">
            <button name="archive" class="archive-btn" type="submit">Archive Product</button>
          </form>
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="hidden" name="id" value="<?= htmlspecialchars($product['id']) ?>">
            <button name="delete" class="delete-btn" type="submit">Delete Product</button>
          </form>
        </div>
      </div>
    </div>

  <?php } ?>
</div>

<!-- Image Modal -->
<div id="imageModal" class="modal" onclick="closeModal()">
  <span class="close">
    <img width="35px" src="/assets/images/icons/close.png" alt="Close">
  </span>
  <img class="modal-content" id="fullImage">
</div>
<script src="/assets/js/admin/single_product.js"></script>

<?php
require './includes/admin_footer.php';
?>