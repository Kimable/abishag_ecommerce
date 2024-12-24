<?php
session_start(); // Start the session to manage cart
$title = 'Cart';

require './partials/head.php'
?>

<div class="container vertical-space cart-container">
  <h1 class="title">Your Cart</h1>

  <div id="cart-list"></div>
  <p class="total-price" id="total-price"></p>
  <button class="btn" id="pay" onclick="saveOrder()">Place Order</button>

  <p><a style="text-align: center; color:var(--purple); font-size:1.2rem" href="products.php">Continue Shopping</a></p>
</div>


<script>
  // Retrieve the cart from localStorage
  let cart = JSON.parse(localStorage.getItem('cart')) || [];
  const cartList = document.getElementById('cart-list');
  const totalPriceElem = document.getElementById('total-price');
  const payBtn = document.getElementById('pay')

  console.log(cart)


  // Function to render the cart items
  function renderCart() {
    cartList.innerHTML = ''; // Clear previous list

    let totalPrice = 0;

    if (cart.length === 0) {
      cartList.innerHTML = `
    <div class='empty-cart'>
       <p>Your Cart is Empty. Start Shopping.</p>
       <img src="./assets/images/empty_cart.png"/>
    </div>
    `
      totalPriceElem.style.display = 'none'
      payBtn.style.display = 'none'
      return
    }
    // Loop through the cart items and display them
    cart.forEach(item => {
      const span = document.createElement('span')
      span.innerHTML = `
      <div class='cart'>
        <div class='img-container'>
        <img src=${item.image} /></div>
       <div class='cart-content'>
        <p>${item.name}</p>  
        <p class='cart-price'>KES ${item.price * item.quantity}</p>
        <span class='action-btns'>
          <span class='decrement-btn' onclick="updateQuantity(${item.id}, 'decrement')">-</span>
          <span class='qty-btn'>${item.quantity}</span>
          <span class='increment-btn' onclick="updateQuantity(${item.id}, 'increment')">+</span>
       </span>
       </div> 
       <span class='remove-btn' onclick="remove(${item.id})"><span class="material-symbols-outlined">delete</span></span>
      
      </div>`;

      cartList.appendChild(span);
      // Calculate total price
      totalPrice += item.price * item.quantity;
    });

    // Update total price
    totalPriceElem.innerText = 'Total: KES ' + totalPrice;
  }

  // Function to update item quantity (increment or decrement)
  function updateQuantity(id, action) {
    // Find the item in the cart
    const item = cart.find(product => parseInt(product.id) === id);
    console.log(item);

    if (action === 'increment') {
      item.quantity++;
    } else if (action === 'decrement') {
      item.quantity--;
      if (item.quantity <= 0) {
        // Remove the item from the cart if quantity is zero
        cart = cart.filter(product => parseInt(product.id) !== id);
      }
    }

    // Update the cart in localStorage
    localStorage.setItem('cart', JSON.stringify(cart));

    // Re-render the cart
    renderCart();
  }

  function remove(id) {
    cart = cart.filter(product => parseInt(product.id) !== id);
    // Update the cart in localStorage
    localStorage.setItem('cart', JSON.stringify(cart));
    // Re-render the cart
    renderCart();
  }
  // Initial render of the cart
  renderCart();

  // Send cart content to backend
  function saveOrder() {
    console.log(cart)
    if (cart.length !== 0) {
      fetch('/api/orders.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(cart)
        })
        .then(response => response.json())
        .then(data => console.log(data))
        .catch(error => console.error('Error:', error));
    } else {
      const message = "The Cart is empty"
      return message
    }

  }
</script>

<?php include './partials/footer.php' ?>