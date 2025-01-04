<?php
$title = "Unauthorized";

require './includes/header.php';
?>


<div style="margin: 3rem 0;">
  <div class="container" style="text-align: center;">
    <p class="danger" style="font-size: 4rem; font-weight:800">401</p>
    <h1 class="danger">Unauthorized</h1>
    <p>You are not authorized to view that Page.</p>
    <a href="/user" class="btn">Go to Your Dashboard</a>
  </div>
</div>

<?php require './includes/footer.php'; ?>