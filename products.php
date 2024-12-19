<?php
$title = "Products";
require './functions/GetAllProducts.php';

require './partials/head.php';
?>
<div class="container vertical-space">
  <h1>Products</h1>

  <div class="column-container">

    <?php if (count($items) === 0): ?>
      <div style="display: block;">
        <p>Sorry, products in that category have not been added yet. Please check again later.</p>
        <a href="/products.php" class="btn">Explore Other Products</a>

        <!-- Recommendations -->
        <?php require __DIR__ . "/partials/recommended.php" ?>
      </div>

    <?php endif ?>

    <?php foreach ($items as $item): ?>

      <div class="col product">
        <?php $img = $item['main_image'] ?>


        <a class="img-container" href="/product.php?slug=<?= htmlspecialchars($item['slug']); ?>&prod_id=<?= htmlspecialchars($item['id']); ?>">
          <?php if (htmlspecialchars($item['offer_price']) != 0): ?>
            <div class="offer-tag">OFFER!!!</div>
          <?php endif ?>
          <img src='<?= $img ?>' alt='<?= htmlspecialchars($item["name"]); ?>'>
        </a>
        <h3><?= substr(htmlspecialchars($item['name']), 0, 50); ?>...</h3>

        <!-- Offer Price Check -->
        <?php if (htmlspecialchars($item['offer_price']) == 0) : ?>

          <p class="price">KES <?= htmlspecialchars($item['price']); ?></p>

        <?php else : ?>

          <p class="offer-price">KES <?= htmlspecialchars($item['offer_price']); ?> <small class="was-price">KES <?= htmlspecialchars($item['price']); ?> </small></p>
        <?php endif ?>
        <!-- Add to cart -->

        <button class="cart-btn" type="submit" onclick="addToCart('<?= $item['id'] ?>', '<?= $item['name'] ?>',  '<?= $img ?>',  '<?php echo $item['offer_price'] != 0 ? $item['offer_price'] : $item['price'] ?>')">Add to Cart
          <span class="material-symbols-outlined">
            local_mall
          </span>
        </button>


      </div>
    <?php endforeach; ?>
  </div>

  <!-- Pagination -->
  <?php if ($total_pages > 0) { ?>
    <div class="pagination">
      <?php if ($page > 1): ?>
        <a class="btn" href="/products.php?page=<?= $page - 1 ?>">Previous Page</a>
      <?php endif; ?>

      <?php if ($page < $total_pages): ?>
        <a class="btn" href="/products.php?page=<?= $page + 1 ?>">More Products</a>
      <?php endif; ?>
      <p>Page <?= $page ?> of <?= $total_pages ?></p>
    </div>
  <?php } ?>


</div>
<script src="/assets/js/cartPopUp.js"></script>
<script>
  const cartPopup = new CartPopup();

  function addToCart(id, name, image, price) {
    // Get cart from localStorage or initialize it as an empty array
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    // Check if the item already exists in the cart
    let item = cart.find(product => product.id === id);

    if (item) {
      // If item exists, increment the quantity
      item.quantity++;
    } else {
      // If item doesn't exist, add a new item

      cart.push({
        id: id,
        name: name,
        image,
        price: price,
        quantity: 1
      });
    }

    // Store the updated cart back into localStorage
    localStorage.setItem('cart', JSON.stringify(cart));

    cartPopup.show('Successfully added to cart!');
  }
</script>
<?php require './partials/footer.php' ?>