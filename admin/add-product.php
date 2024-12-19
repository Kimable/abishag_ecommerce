<?php
require './functions/ManageProduct.php';
$add = addProduct();
require  './includes/admin_head.php';
?>

<div class="add-product">
  <h1>Add A Product</h1>

  <?php if ($add && $add['status'] == "err") { ?>
    <p class='error'> <?= htmlspecialchars($add['message']) ?> </p>
  <?php } ?>
  <?php if ($add && $add['status'] == "ok") { ?>
    <p class='success'> <?= htmlspecialchars($add['message']) ?>. <a href="/admin/product.php?slug=''&prod_id=<?= $add['id'] ?>">View Product</a> </p>
  <?php }  ?>

  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
    <div class="form-inputs">
      <div class="input-container">
        <label for="productName">Product Name</label>
        <input type="text" name="productName" id="productName" value="<?= $add ? $add['productName'] : "" ?>" required>
      </div>

      <div class="input-container">
        <label for="price">Product Price</label>
        <input type="number" name="price" id="price" value="<?= $add ? $add['price'] : "" ?>" required>
      </div>

      <div class="input-container">
        <label for="quantity">Product Quantity</label>
        <input type="number" name="quantity" id="quantity" value="<?= $add ? $add['quantity'] : "" ?>">
      </div>

      <div class="input-container">
        <label for="category">Product Category</label>
        <select name="category" id="category">
          <option value="uncategorized" selected>--Select Category--</option>
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
          <option value="0" selected>--Select Tag--</option>
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
        <label for="offer_price">Offer Price</label>
        <input type="number" name="offer_price" id="offer_price" value="<?= $add ? $add['offer_price'] : "" ?>">
      </div>

      <div class="input-container">
        <label for="description">Product Description</label>
        <textarea name="description" id="description" rows="6" cols="40"><?= $add ? $add['description'] : "" ?></textarea>
      </div>


      <div class="input-container">
        <label for="image">Product Image(s)</label>
        <input type="file" id="image" name="product_images[]" multiple accept="image/*" required>
      </div>

      <br>

    </div>
    <div class="form-submit-btn">
      <button type="submit" class="btn">Add Product</button>
    </div>
  </form>
</div>

<?php
require  './includes/admin_footer.php';
?>

<style>
  .add-product form {
    background-color: var(--light-pink);
    padding: 1rem;
    margin-top: 1rem;
  }

  .add-product .form-inputs {
    display: flex;
    flex-wrap: wrap;
  }

  .add-product .input-container {
    width: 30%;
    margin: 0.75rem;
  }

  .add-product .input-container input,
  .add-product textarea,
  .add-product select {
    border-radius: 8px;
  }

  .add-product .btn {
    margin-left: 1rem;
  }

  /* Images */
  #preview {
    display: flex;
    gap: 10px;
    margin-top: 10px;
    flex-wrap: wrap;
  }

  #preview .image-container {
    position: relative;
    width: 100px;
    height: 100px;
  }

  #preview .image-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border: 2px solid #ccc;
    border-radius: 5px;
    cursor: pointer;
  }

  #preview .image-container img.selected {
    border-color: var(--pink);
  }

  #preview .image-container .main-badge {
    position: absolute;
    top: 5px;
    left: 5px;
    background-color: var(--pink);
    color: #fff;
    font-size: 12px;
    padding: 2px 5px;
    border-radius: 3px;
  }


  @media (max-width:750px) {
    .add-product form label {
      font-size: 14px;
    }

    .add-product .input-container {
      width: 100%;
    }
  }
</style>

<script>

</script>