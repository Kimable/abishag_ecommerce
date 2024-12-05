<?php
// Pagination logic
require './functions/GetAllProducts.php';

?>


<div class="container">
  <div class="hot">
    <p class="title-intro icon-container"><span class="material-symbols-outlined">
        flash_on
      </span>Just In</p>
    <h2 class="subtitle">Hot Picks</h2>

    <div class="column-container">
      <?php foreach ($items as $item): ?>

        <div class="col">
          <a href="/product.php?slug=<?= htmlspecialchars($item['slug']); ?>">
            <?php
            $images = explode(",", $item['images']);
            $mainImg = $images[0];
            ?>
            <img src='<?= $mainImg ?>' alt='<?= htmlspecialchars($item["name"]); ?>'>
            <p id="text"><?= substr(htmlspecialchars($item['name']), 0, 20); ?></p>
            <p id="price">KES <?= htmlspecialchars($item['price']); ?></p>
          </a>
        </div>
      <?php endforeach; ?>
    </div>
    <a href="/products.php" class="btn">More Products</a>
  </div>
</div>

<style>
  .hot {
    margin: 1.3rem 0;
  }

  .hot a {
    text-decoration: none;
    color: var(--text);
  }

  .hot #text {
    font-size: .85rem;
  }

  .hot .column-container .col {
    width: 19%;
    padding: 0;
  }

  .hot .btn {
    text-align: center;
    color: var(--light);
  }

  .hot img {
    width: 100%;
    object-fit: cover;
    object-position: top;
    height: 180px;
    border-radius: 10px 10px 0 0;

  }

  .hot .col p {
    padding: 0.3rem 0.76rem;
    font-weight: 600;

  }

  #price {
    color: var(--purple);
    font-weight: 800;
  }

  @media (max-width:850px) {
    .hot .column-container .col {
      width: 32%;
    }
  }

  @media (max-width:650px) {
    .hot .column-container .col {
      width: 47.5%;
    }

    .hot img {
      height: 180px;
    }
  }
</style>

<script>

</script>