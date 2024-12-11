<?php
$title = "Add Product";
include './functions/AddProduct.php';
include './partials/head.php'
?>
<div class="vertical-space">
  <div class="container form">
    <h1>Add A Product</h1>
    <?php echo $message != "" ? "<p class='error'>  $message </p>" : ""; ?>
    <?php echo $successMsg != "" ? "<p class='success'>  $successMsg </p>" : ""; ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
      <div class="input-container">
        <label for="productName">Product Name</label>
        <input type="text" name="productName" id="productName" value="<?php echo $productName ?>" required>
      </div>

      <div class="input-container">
        <label for="price">Product Price</label>
        <input type="number" name="price" id="price" value="<?php echo $price ?>" required>
      </div>

      <div class="input-container">
        <label for="quantity">Product Quantity</label>
        <input type="number" name="quantity" id="quantity" value="<?php echo $quantity ?>">
      </div>

      <div class="input-container">
        <label for="description">Product Description</label>
        <textarea name="description" id="description" rows="6" cols="60"><?php echo $description ?></textarea>
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
        <input type="number" name="offer_price" id="offer_price" value="<?php echo $offer_price ?>">
      </div>


      <div class="input-container">
        <label for="image">Product Image(s)</label>
        <input type="file" id="image" name="product_images[]" multiple accept="image/*" required>
      </div>
      <br>


      <button type="submit" class="btn">Add Product</button>
    </form>
  </div>
</div>
<?php include './partials/footer.php' ?>