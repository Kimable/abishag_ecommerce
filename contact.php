<?php
$title = 'Contact Us';
require './partials/head.php';
?>

<!-- Our story -->
<div class="contact">
  <div class="container">
    <div class="contact-content">
      <p class="title-intro">
        Always here for You
      </p>
      <h1 class="title">Talk To Us</h1>
      <div class="contact-info">
        <p class="icon-container"><span class="material-symbols-outlined">
            phone_enabled
          </span>0712356789</p>
        <p class="icon-container"><span class="material-symbols-outlined">
            email
          </span>info@abishag.co.ke</p>
      </div>


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
          <label for="message"> Message </label>
          <textarea name="message" id="message" cols="30" rows="10"></textarea>

        </div>
        <button type="submit" class="btn">Send Message</button>
      </form>
    </div>
  </div>
</div>
<div class="container">
  <h2 class="icon-container"><span class="material-symbols-outlined">
      location_on
    </span>Visit Us</h2>
  <a href="https://maps.app.goo.gl/svSAJwC1iLZqAu7n6">
    <img class="map" src="./assets/images/abishag-map.png" alt="Location">
  </a>
</div>
<style>
  .contact-content {
    text-align: left;
    width: 50%;
  }

  .title-intro,
  .title {
    text-align: center;
  }

  h2 {
    margin: 1rem 0;
    font-size: 1.5rem;
    text-transform: uppercase;
    color: var(--purple);
  }

  .contact-info {
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 1.2rem 0;
  }

  .contact-info p {
    font-size: 1.2rem;
    margin: 0.5rem;
    font-weight: 700;

  }

  .contact-info .icon-container span {
    font-size: 2rem;
    color: var(--purple);
  }

  .map {
    margin-bottom: 1rem;
  }

  @media (max-width:650px) {
    .contact-content {
      width: 92%;
    }

    .contact-info {
      flex-direction: column;
    }

    .contact-info p {
      font-size: 1.1rem;
    }
  }
</style>

<?php require './partials/footer.php';  ?>