<?php
$title = "Success";
include './partials/head.php';
?>

<div class="container">
  <div class="subscription">
    <h1>Subscription Successful</h1>
    <p>Your Subscription was Successful. You will be the first to know when we've got new collection</p>
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