<?php
require './functions/ManageProduct.php';
updateProduct();
$deleteMsg = deleteProduct();
updateProductImages();
archiveProduct();


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

<h1>Manage Product</h1>
<?php if ($deleteMsg) { ?>
  <p class="error"><?= $deleteMsg ?></p>
<?php } ?>
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
          <img id="thumbnail" src="<?= $img['image_path'] ?>" alt="<?= $product['name'] . " " . $img['id'] ?>" onclick="openModal(this)">
        <?php endforeach ?>
      </div>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="details-form">
        <h3>Product Details</h3>
        <div class="input-container">
          <label>Product Name:</label>
          <input type="text" name='productName' id="productName" value="<?= $product['name'] ?>" class="highlight">
        </div>

        <div class="input-container">
          <label>Product Price:</label>
          <input type="text" name='productName' id="productName" value="<?= $product['price'] ?>" class="highlight">
        </div>

        <div class="input-container">
          <label>Product Quantity:</label>
          <input type="text" name='productName' id="productName" value="<?= $product['quantity'] ?>" class="highlight">
        </div>

        <div class="input-container">
          <label>Offer Price:</label>
          <input type="text" name='productName' id="productName" value="<?= $product['offer_price'] ?>" class="highlight">
        </div>

        <div class="input-container">
          <label>Product Category:</label>
          <input type="text" name='productName' id="productName" value="<?= $product['category'] ?>" class="highlight">
        </div>

        <div class="input-container">
          <label>Product Tag:</label>
          <input type="text" name='productName' id="productName" value="<?= $product['tag'] ?>" class="highlight">
        </div>

        <div class="input-container">
          <label>Product Description:</label>
          <textarea class="highlight" name="description" id="description" rows="6" cols="30"><?= $product['description'] ?></textarea>
        </div>
        <button class="btn" type="submit">Save Changes</button>
      </form>

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

<style>
  .manage-single-product #images {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin: 0.5rem 0;
  }

  .manage-single-product .product-detail .details-form {
    box-shadow: 1px 5px 5px 1px rgba(0, 0, 0, 0.2);
    padding: 0.5rem;
    border-radius: 10px;
  }

  .manage-single-product #images #thumbnail {
    width: 80px;
    border-radius: 10px;
    cursor: pointer;
  }

  .manage-single-product h3 {
    margin: 1rem 0;
    text-decoration: underline;
    color: var(--purple);
  }

  .manage-single-product .product-detail p {
    font-weight: 700;
    margin-bottom: 0.75rem;
  }

  .manage-single-product .product-detail input,
  .manage-single-product .product-detail textarea {
    color: var(--purple);
    font-weight: 700;
    padding: 0.5rem 0;
    border: none;
    outline: none;
  }

  .manage-single-product .product-detail input:focus-visible,
  .manage-single-product .product-detail textarea:focus-visible {
    padding: 0.5rem;
    border: 1.5px solid var(--purple);
    border-radius: 7px;
  }

  .manage-single-product .input-container label {
    margin: 0;
  }

  .danger-zone div {
    display: flex;
    gap: 10px;
  }

  .delete-btn,
  .archive-btn {
    background-color: red;
    border: none;
    cursor: pointer;
    padding: 0.5rem 0.75rem;
    color: var(--light);
    font-size: 1rem;
    border-radius: 18px;
  }

  .archive-btn {
    background-color: var(--dark);
  }

  /* Modal styles */
  .modal {
    display: none;
    /* Hidden by default */
    position: fixed;
    z-index: 1000;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.8);
    /* Semi-transparent background */
    justify-content: center;
    align-items: center;
  }

  .modal-content {
    margin: auto;
    display: block;
    max-width: 90%;
    max-height: 90%;
    border-radius: 10px;
    box-shadow: 0 8px 15px rgba(255, 255, 255, 0.1);
  }

  .modal .close {
    position: absolute;
    top: 20px;
    right: 30px;
    color: white;
    font-size: 30px;
    font-weight: bold;
    cursor: pointer;
    transition: color 0.3s ease;
  }

  .modal .close:hover {
    color: #ccc;
  }
</style>
<script>
  // Function to open the modal and display the clicked image
  function openModal(image) {
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('fullImage');

    modal.style.display = 'flex';
    modalImage.src = image.src; // Set the modal image source to the clicked image source
  }

  // Function to close the modal
  function closeModal() {
    const modal = document.getElementById('imageModal');
    modal.style.display = 'none';
  }
</script>

<?php
require './includes/admin_footer.php';
?>