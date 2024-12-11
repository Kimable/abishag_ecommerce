<div class="product-categories">
  <p class="title-intro icon-container"><span class="material-symbols-outlined">
      favorite
    </span>Featured Favourites</p>
  <h2 class="subtitle">Product Categories</h2>
  <div class="column-container">
    <div class="col">
      <a href="/products.php?category=wigs">
        <!-- <img src="./assets/images/wig1.jpg" alt="Hair care & Styling"> -->
        <p id="text">Wigs & Weaves</p>
      </a>
    </div>
    <div class="col">
      <a href="/products.php?category=hair-care-styling">
        <!-- <img src="./assets/images/wig1.jpg" alt="Hair care & Styling"> -->
        <p id="text">Hair care & Styling</p>
      </a>
    </div>
    <div class="col">
      <a href="/products.php?category=hair-extensions">
        <!-- <img src="./assets/images/extension.webp" alt="Premium hair extensions"> -->
        <p>Premium hair extensions</p>
      </a>
    </div>
    <div class="col">
      <a href="/products.php?category=hair-products">
        <!-- <img src="./assets/images/hair-care.webp" alt="Specialized hair care products"> -->
        <p id="text">Specialized hair care products</p>
      </a>
    </div>
    <div class="col">
      <a href="/products.php?category=hair-styling-tools">
        <!-- <img src="./assets/images/styling-tools.jpg" alt="Professional styling tools"> -->
        <p>Professional styling tools</p>
      </a>
    </div>
    <div class="col">
      <a href="/products.php?category=hair-accessories">
        <!-- <img src="./assets/images/hair-bands.jpg" alt="Hair essentials and accessories"> -->
        <p>Hair essentials and accessories</p>
      </a>
    </div>
    <div class="col">
      <a href="/products.php?category=hair-installation-services">
        <!-- <img src="./assets/images/natural-human-hair.webp" alt="Expert installation services"> -->
        <p id="text">Expert installation services</p>
      </a>
    </div>
    <div class="col">
      <a href="/products.php?category=hair-maintenance">
        <!-- <img src="./assets/images/wiggins.jpg" alt="Ongoing maintenance support"> -->
        <p id="text">Ongoing maintenance support</p>
      </a>
    </div>
  </div>
</div>

<style>
  .product-categories {
    margin: 1rem 0;
  }

  .product-categories a {
    text-decoration: none;
    color: var(--light);
    display: flex;
    height: 180px;
    align-items: center;
  }

  .product-categories .column-container .col {
    height: 200px;
    border-radius: 12px;
    margin: 0.55rem;
    width: 23%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    color: var(--light);
  }



  .product-categories .column-container .col:nth-child(1) {
    background: linear-gradient(0deg, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
      url(./assets/images/wig.jpg);
  }

  .product-categories .column-container .col:nth-child(2) {
    background: linear-gradient(0deg, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
      url(./assets/images/wig1.jpg);
  }

  .product-categories .column-container .col:nth-child(3) {
    background: linear-gradient(0deg, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
      url(./assets/images/extension.webp);
  }

  .product-categories .column-container .col:nth-child(4) {
    background: linear-gradient(0deg, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
      url(./assets/images/hair-care.webp);
  }

  .product-categories .column-container .col:nth-child(5) {
    background: linear-gradient(0deg, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
      url(./assets/images/styling-tools.jpg);
  }

  .product-categories .column-container .col:nth-child(6) {
    background: linear-gradient(0deg, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
      url(./assets/images/hair-bands.jpg);
  }

  .product-categories .column-container .col:nth-child(7) {
    background: linear-gradient(0deg, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
      url(./assets/images/natural-human-hair.webp);
  }

  .product-categories .column-container .col:nth-child(8) {
    background: linear-gradient(0deg, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
      url(./assets/images/wiggins.jpg);
  }

  .product-categories .column-container .col:nth-child(1),
  .product-categories .column-container .col:nth-child(2),
  .product-categories .column-container .col:nth-child(3),
  .product-categories .column-container .col:nth-child(4),
  .product-categories .column-container .col:nth-child(5),
  .product-categories .column-container .col:nth-child(6),
  .product-categories .column-container .col:nth-child(7),
  .product-categories .column-container .col:nth-child(8) {
    background-size: cover;
    background-repeat: no-repeat;
    background-position: top;
    padding: 0.65rem;
  }

  .product-categories img {
    width: 100%;
    object-fit: cover;
    object-position: top;
    height: 250px;

  }

  .product-categories .col p {
    padding: 0.76rem;
    font-weight: 600;
    font-size: 1rem;
  }

  @media (max-width:850px) {
    .product-categories .column-container .col {
      width: 30%;
    }
  }

  @media (max-width:650px) {
    .product-categories .column-container .col {
      width: 45%;
    }

    .product-categories img {
      height: 180px;
    }
  }
</style>

<script>

</script>