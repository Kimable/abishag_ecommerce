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
        <p>No products added yet.</p>
      </div>
    <?php endif ?>

    <?php foreach ($items as $item): ?>

      <div class="col product">
        <?php $img = $item['main_image'] ?>

        <a href="/product.php?slug=<?= htmlspecialchars($item['slug']); ?>">
          <img src='<?= $img ?>' alt='<?= htmlspecialchars($item["name"]); ?>'>
        </a>
        <h2><?= substr(htmlspecialchars($item['name']), 0, 20); ?>...</h2>
        <p class="price offer">Price: KES <?= htmlspecialchars($item['price']); ?></p>

        <!-- Add to cart -->

        <button class="cart-btn" type="submit" onclick="addToCart('<?= $item['id'] ?>', '<?= $item['name'] ?>',  '<?= $img ?>',  '<?= $item['price'] ?>')">Add to Cart
          <span class="material-symbols-outlined">
            local_mall
          </span>
        </button>


      </div>
    <?php endforeach; ?>
  </div>

  <!-- Pagination Links -->
  <div class="pagination">
    <?php if ($page > 1): ?>
      <a class="btn" href="/products.php?page=<?= $page - 1 ?>">Previous Page</a>
    <?php endif; ?>

    <?php if ($page < $total_pages): ?>
      <a class="btn" href="/products.php?page=<?= $page + 1 ?>">More Products</a>
    <?php endif; ?>
    <p>Page <?= $page ?> of <?= $total_pages ?></p>
  </div>


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