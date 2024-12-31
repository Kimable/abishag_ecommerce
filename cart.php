<?php
session_start();
$title = 'Cart';

require './partials/head.php'
?>

<div class="container vertical-space cart-container">
  <h1 class="title">Your Cart</h1>

  <div id="cart-list"></div>
  <p class="total-price" id="total-price"></p>
  <?php if (!isset($_SESSION['user_id'])) { ?>
    <a href="/login.php" class="btn">Login to place order</a>
  <?php } else { ?>
    <button class="btn" id="pay" onclick="saveOrder('<?= $_SESSION['user_id'] ?>')">Place Order</button>
  <?php } ?>
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
    let totalPrice = 0;
    cartList.innerHTML = ''; // Clear previous list

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
  function saveOrder(user_id) {
    console.log(cart)
    if (cart.length !== 0) {
      fetch('/api/orders.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            user_id,
            status: 'pending',
            totalAmt: cart.reduce((acc, item) => acc + item.price * item.quantity, 0),
            deliveryAddress: "Not provided",
            cart
          })
        })
        .then(response => {
          if (response.status !== 201) {
            const errorMessage = "An error occurred. Please try again."
            alert(errorMessage);
          }
          return response.json()
        })
        .then(data => {
          console.log(data)
          if (data.message === "Cart is empty") {
            alert("The Cart is empty")
          } else {
            alert("Order placed successfully")
            localStorage.removeItem('cart');
            window.location.href = '/user/order.php?order_id=' + data.orderId;
          }
        })
        .catch(error => {
          const errorMessage = "An error occurred. Please try again. " + error
          alert(errorMessage);
          return errorMessage;
        });
    } else {
      const errorMessage = "The Cart is empty"
      alert(errorMessage);
      return errorMessage;
    }

  }
</script>

<?php include './partials/footer.php' ?>