<?php
// Fetch the current product SLUG and category/tag from the request or session
$currentProductSlug = $_GET['slug'] ?? "";

try {
  // Make sure it's required(imported) where there's a DB call to use $conn
  $stmt = $conn->prepare("SELECT category FROM products WHERE slug = :slug");
  $stmt->bindParam(':slug', $currentProductSlug, PDO::PARAM_INT);
  $stmt->execute();
  $currentProduct = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$currentProduct) {
    throw new Exception("Product not found.");
  }

  $category = $currentProduct['category'];

  // Fetch recommended products based on the same category
  $stmt = $conn->prepare(
    "SELECT 
        p.id, 
        p.name, 
        p.price, 
        p.offer_price, 
        p.slug,
        COALESCE(
            (SELECT i.image_path FROM product_images AS i WHERE i.product_id = p.id AND i.main = 1 LIMIT 1),
            (SELECT i.image_path FROM product_images AS i WHERE i.product_id = p.id LIMIT 1)
        ) AS image_url FROM products AS p WHERE category = :category AND slug != :slug LIMIT 4"
  );

  $stmt->bindParam(':category', $category, PDO::PARAM_STR);
  $stmt->bindParam(':slug', $currentProductSlug, PDO::PARAM_STR);
  $stmt->execute();

  $recommendedProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if (empty($recommendedProducts)) {
    $stmt = $conn->query("SELECT 
    p.id, 
    p.name, 
    p.price, 
    p.offer_price, 
    p.slug,
    COALESCE(
        (SELECT i.image_path FROM product_images AS i WHERE i.product_id = p.id AND i.main = 1 LIMIT 1),
        (SELECT i.image_path FROM product_images AS i WHERE i.product_id = p.id LIMIT 1)
    ) AS image_url FROM products AS p ORDER BY createdAt DESC  LIMIT 5");

    $recommendedProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
} catch (Exception $e) {
  die("Error fetching recommendations: " . $e->getMessage());
}
?>
<div class="container">
  <div class="vertical-space">
    <h3>Recommended Products</h3>
    <?php if (!empty($recommendedProducts)): ?>
      <div class="recommendations">
        <?php foreach ($recommendedProducts as $product): ?>
          <div class="product-card">
            <a class="img-container" href="/product.php?slug=<?php echo htmlspecialchars($product['slug']); ?>&prod_id=<?= htmlspecialchars($product['id']); ?>">
              <?php if (htmlspecialchars($product['offer_price']) != 0): ?>
                <div class="offer-tag" style="font-size: 10px;">OFFER!!!</div>
              <?php endif ?>
              <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
            </a>
            <small><?php echo htmlspecialchars($product['name']); ?></small>
            <!-- Offer Price Check -->
            <?php if (htmlspecialchars($product['offer_price']) == 0) : ?>
              <p style="margin-top: 0.75rem; color: var(--purple); font-weight:700">KES <?= htmlspecialchars($product['price']); ?></p>
            <?php else : ?>
              <p style="margin-top: 0.75rem; color: var(--purple); font-weight:700">KES <?= htmlspecialchars($product['offer_price']); ?></p>
            <?php endif ?>

          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <p>No recommendations available at the moment.</p>
    <?php endif; ?>
  </div>
</div>
<style>
  .recommendations {
    display: flex;
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
</style>