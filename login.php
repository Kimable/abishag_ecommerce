<?php
$title = "Login";
require __DIR__ . '/functions/Login.php';
require __DIR__ . '/partials/head.php'
?>
<div class="vertical-space">
  <div class="container form">
    <?php echo $errorMsg != "" ? "<p class='error'>  $errorMsg </p>" : ""; ?>

    <h1 style="margin-bottom: 1.2rem;">Login to Continue</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($redirect); ?>">
      <div class="input-container">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?php echo $email ?>" required>
      </div>
      <div class="input-container">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" value="<?php echo $password ?>" required>
      </div>
      <button type="submit" class="btn">Login</button>
    </form>
    <small>Don't have an account? <a style="color: var(--pink);" href="/register.php">Register Here</a></small>
  </div>
</div>
<?php require __DIR__ . '/partials/footer.php' ?>