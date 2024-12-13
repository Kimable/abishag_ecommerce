<?php
$title = "Register";
require __DIR__ . '/functions/Register.php';
require __DIR__ . '/partials/head.php'
?>
<div class="vertical-space">
  <div class="container form">
    <h1 style="margin-bottom: 1.5rem;">Register to Continue</h1>
    <?php echo $errorMsg != "" ? "<p class='error'>  $errorMsg </p>" : ""; ?>
    <?php echo $successMsg != "" ? "<p class='success'>  $successMsg </p>" : ""; ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
      <div class="input-container">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="<?php echo $name ?>" required>
      </div>
      <div class="input-container">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?php echo $email ?>" required>
      </div>
      <div class="input-container">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" value="<?php echo $password ?>" required>
      </div>
      <div class="input-container">
        <label for="confirmPassword">Confirm Password</label>
        <input type="password" name="confirmPassword" id="confirmPassword" value="<?php echo $confirmPassword ?>" required>
      </div>
      <button type="submit" class="btn">Register</button>
    </form>
    <small>Already have an account? <a style="color: var(--pink);" href="/login.php">Login Here</a></small>
  </div>
</div>
<?php require __DIR__ . '/partials/footer.php' ?>