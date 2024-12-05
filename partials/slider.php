<?php ?>
<style>
  /* styles.css */
  .slider-container {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 2rem;

  }

  .slider {
    position: relative;
    width: 80%;
    overflow: hidden;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
  }

  .slides {
    display: flex;
    transition: transform 0.5s ease-in-out;
  }

  .slide {
    min-width: 100%;
    box-sizing: border-box;
    position: relative;
  }

  .slide img {
    width: 100%;
    height: 450px;
    object-fit: cover;
    object-position: top;
    display: block;
    border-radius: 8px;
  }

  .caption {
    position: absolute;
    bottom: 20px;
    left: 20px;
    color: white;
    font-size: 24px;
    font-weight: bold;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
    background-color: rgba(0, 0, 0, 0.5);
    padding: 10px;
    border-radius: 4px;
  }

  button {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background-color: rgba(0, 0, 0, 0.5);
    border: none;
    color: white;
    font-size: 24px;
    padding: 8px;
    cursor: pointer;
    transition: background-color 0.3s;
  }

  button:hover {
    background-color: rgba(0, 0, 0, 0.7);
  }

  .prev {
    left: 10px;
  }

  .next {
    right: 10px;
  }
</style>
<div class="slider-container">
  <div class="slider">
    <div class="slides">
      <div class="slide">
        <img src="../assets/images/empty_cart.png" alt="Slide 1">
        <div class="caption">This is Slide 1</div>
      </div>
      <div class="slide">
        <img src="../assets/images/Not_found.png" alt="Slide 2">
        <div class="caption">This is Slide 2</div>
      </div>
      <div class="slide">
        <img src="../assets/images/By_the_road.png" alt="Slide 3">
        <div class="caption">This is Slide 3</div>
      </div>
    </div>
    <button class="prev" onclick="moveSlide(-1)">&#10094;</button>
    <button class="next" onclick="moveSlide(1)">&#10095;</button>
  </div>

</div>
<script>
  // script.js
  let currentSlide = 0;
  const slides = document.querySelector('.slides');
  const totalSlides = document.querySelectorAll('.slide').length;

  function updateSlide() {
    slides.style.transform = `translateX(-${currentSlide * 100}%)`;
  }

  function moveSlide(direction) {
    currentSlide = (currentSlide + direction + totalSlides) % totalSlides;
    updateSlide();
  }
</script>