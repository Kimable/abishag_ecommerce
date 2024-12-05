<?php
$title = "Success";
include './partials/head.php';
?>

<div class="container">
  <div class="subscription">
    <h1>Message Send Successfully</h1>
    <p>Great! We've received your message. We'll reach to you as soon as possible</p>
    <a href="/products.php" class="btn">Explore our recent collection</a>
  </div>
</div>

<?php include './partials/footer.php'; ?>

<style>
  .subscription {
    height: 100%;
    margin: 2.5rem 0;
    text-align: center;
  }

  .subscription h1 {
    color: green;
  }
</style>