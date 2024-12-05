<?php
$title = 'Consultation';
require './partials/head.php';
?>

<!-- Our story -->
<div class="contact">
  <div class="container">
    <div class="contact-content">
      <p class="title-intro">
        Expert Advice
      </p>
      <h1 class="title">Book A Consultation</h1>
      <p>Please fill this form and an expert will reach out to you shortly</p>
      <form action="/forms/contact.php" method="post">
        <div class="input-container">
          <label for="name" id="name">Your Name</label>
          <input type="text" name="name" id="name">
        </div>

        <div class="input-container">
          <label for="email">Your Email </label>
          <input type="email" name="email" id="email" required>

        </div>

        <div class="input-container">
          <label for="phone">Phone No.</label>
          <input type="text" name="phone" id="phone" required>
        </div>

        <div class="input-container">
          <label for="message"> Inquiry </label>
          <textarea name="message" id="message" cols="30" rows="10"></textarea>

        </div>
        <button type="submit" class="btn">Book Consultation Now</button>
      </form>
    </div>
  </div>
</div>
<style>
  .contact-content {
    text-align: left;
    width: 50%;
  }

  @media (max-width:650px) {
    .contact-content {
      width: 90%;
    }
  }
</style>

<?php require './partials/footer.php';  ?>