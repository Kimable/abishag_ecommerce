<?php
$title = "Home";
include './partials/head.php';
?>
<!-- Hero -->


<div class="hero">
  <div class="left">
    <p class="title-intro">Unleash your perfect look</p>
    <h1 class="title">DISCOVER YOUR CROWN'S POTENTIAL</h1>
    <p>Transform your look with premium hair extensions and professional-grade products crafted for queens who deserve the best. Whether it's your wedding day or every day, we're here to help you achieve the royal treatment you deserve.</p>
    <a href="/products.php" class="btn">Shop Now</a><a href="/consultation.php" class="btn" style="margin-left: 0.2rem; background:var(--purple)">Book Consultation</a>
  </div>
  <div class="right">
    <img src="./assets/images/hair-style.jpg" alt="Hair Style">
  </div>
</div>

<!-- Hero Ends -->

<!-- Hot picks section -->
<?php require './partials/hot_picks.php' ?>

<!-- Product categories -->
<div class="container vertical-space">

  <?php include './partials/product-categories.php' ?>

</div>

<!-- Extension section -->
<div class="container">
  <p class="title-intro icon-container"><span class="material-symbols-outlined">
      health_and_beauty
    </span>Extensions Collection</p>
  <h2 class="subtitle" style="text-transform:capitalize;">premium extensions, endless possibilities</h2>
  <p>Discover our carefully curated collection of premium hair extensions, sourced for quality and styled for perfection. Available in various textures, lengths, and colors to match your unique beauty.</p>
  <div class="extensions">
    <div>
      <p>100% Premium Quality Hair</p>
    </div>
    <div>
      <p>Multiple Application Methods</p>
    </div>
    <div>
      <p>Expert Installation Guide Included</p>
    </div>
    <div>
      <p>Perfect Color Match Guarantee</p>
    </div>
  </div>
</div>


<!-- Subscriptions -->
<div class="container">
  <div class="subscribe">
    <div class="content">
      <p>Subscribe to our newsletter to get updates of our latest collection</p>
      <form action="/forms/subscribe.php" method="post">
        <input type="email" name="email" id="email" placeholder="Email" required> <button type="submit" class="btn">Subscribe</button>
      </form>
    </div>
  </div>
  <style>
    .subscribe {
      background-color: var(--light-pink);
      margin: 1.5rem 0;
      border-radius: 16px;
    }

    .subscribe .content {
      text-align: center;
      margin: 0 auto;
      width: 60%;
      padding: 2rem 0;
    }

    .subscribe p {
      font-size: 1.35rem;
      font-weight: 700;
    }

    .subscribe input {
      padding: 0.65rem;
      border: 1px solid;
      border-radius: 17px;
    }

    @media (max-width:650px) {
      .subscribe .content {
        width: 100%;
      }
    }
  </style>
</div>

<?php include './partials/footer.php' ?>