<?php
require __DIR__ . '/../functions/GetAllProducts.php';
require  './includes/admin_head.php';
?>

<h1>Manage Products</h1>
<?php if ($loading == true): ?>
  <h1>Loading...</h1>
<?php else: ?>
  <?php if (!empty($items)): ?>
    <div class="manage-products">
      <?php foreach ($items as $product): ?>
        <?php if ($product['archive'] == null) : ?>
          <div class="product-card">
            <a class="img-container" href="/admin/product.php?&status=ok&message=&slug=<?php echo htmlspecialchars($product['slug']); ?>&prod_id=<?= htmlspecialchars($product['id']); ?>">
              <?php if (htmlspecialchars($product['offer_price']) != 0): ?>
                <div class="offer-tag" style="font-size: 10px;">OFFER!!!</div>
              <?php endif ?>
              <img src="<?php echo htmlspecialchars($product['main_image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
            </a>
            <small><?php echo htmlspecialchars($product['name']); ?></small>
            <!-- Offer Price Check -->
            <?php if (htmlspecialchars($product['offer_price']) == 0) : ?>
              <p style="margin-top: 0.75rem; color: var(--purple); font-weight:700">KES <?= htmlspecialchars($product['price']); ?></p>
            <?php else : ?>
              <p style="margin-top: 0.75rem; color: var(--purple); font-weight:700">KES <?= htmlspecialchars($product['offer_price']); ?></p>
            <?php endif ?>

          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <p>You Have Not Added Any Product</p>
    <a class="btn" href="/admin/add-product.php">Add A Product Here</a>
  <?php endif; ?>
<?php endif; ?>

<!-- Pagination Links -->
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

<style>
  .manage-products {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-top: 20px;
  }

  .product-card {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 10px;
    width: 200px;
    text-align: center;
  }

  .product-card img {
    max-width: 100%;
    height: auto;
  }

  @media (max-width:600px) {
    .product-card {
      width: 100%;
    }
  }
</style>


<?php
require './includes/admin_footer.php';
?>