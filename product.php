<?php
$title = "Product";
require './util/DB_connect.php';
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


require './partials/head.php'
?>

<div class="container vertical-space">
  <?php if ($errorMsg == '' && $product != null) { ?>

    <?php $mainImg = $images[0]['image_path'];
    foreach ($images as $image) {
      if ($image['main'] === 1) {
        $mainImg = $image['image_path'];
      }
    }
    ?>
    <div class="single-product">
      <div class="product-img img-container">
        <?php if (htmlspecialchars($product['offer_price']) != 0): ?>
          <div class="offer-tag">OFFER!!!</div>
        <?php endif ?>
        <img src="<?= $mainImg ?>" alt="<?= htmlspecialchars($product['name']); ?>" onclick="openModal(this)">
        <!-- Thumbnail imgs -->
        <div id="thumbnails">
          <?php foreach ($images as $img): ?>
            <img id="thumbnail" src="<?= $img['image_path'] ?>" alt="<?= $product['name'] . " " . $img['id'] ?>" onclick="openModal(this)">
          <?php endforeach ?>
        </div>
      </div>
      <div class="product-details">
        <h1 style="margin-bottom: 0.75rem;"><?= htmlspecialchars($product['name']); ?></h1>
        <p class="description"><strong>Description:</strong> <?= substr(htmlspecialchars($product['description']), 0, 200); ?></p>


        <?php if (htmlspecialchars($product['offer_price']) == 0) : ?>

          <p class="price">KES <?= htmlspecialchars($product['price']); ?></p>

        <?php else : ?>

          <p class="price">KES <?= htmlspecialchars($product['offer_price']); ?> <small class="was-price">KES <?= htmlspecialchars($product['price']); ?> </small></p>
        <?php endif ?>

        <button class="cart-btn" type="submit" onclick="addToCart('<?= $product['id'] ?>', '<?= $product['name'] ?>',  '<?= $mainImg ?>',  '<?php echo $product['offer_price'] != 0 ? $product['offer_price'] : $product['price'] ?>')">Add to Cart
          <span class="material-symbols-outlined">
            local_mall
          </span>
        </button>
      </div>
    </div>
  <?php } else { ?>
    <div class="not-found-product">
      <h1>
        <?= $errorMsg; ?>
      </h1>

      <div>
        <p>This product does not exist in our database.</p>
        <a class="btn" href="/products.php">Find another product</a>
      </div>
      <img src="./assets/images/Not_found.png" alt="Product Not found">

    <?php } ?>
    </div>
</div>
<!-- Recommendations -->
<?php require __DIR__ . "/partials/recommended.php" ?>

<!-- Modal -->
<div id="imageModal" class="modal" onclick="closeModal()">
  <span class="close">
    <span class="material-symbols-outlined">
      cancel
    </span>
  </span>
  <img class="modal-content" id="fullImage">
</div>
<style>
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
<script src="/assets/js/cartPopUp.js"></script>
<script>
  // Create the popup (only once in your application)
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
<?php require './partials/footer.php' ?>