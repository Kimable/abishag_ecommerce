<div class="sidebar">
  <img class="logo" src="../../assets/images/abishag-logo.png" alt="Logo">
  <ul>
    <li><a href="/admin/add-product.php">Add Product</a></li>
    <li><a href="/admin/manage-products.php">Manage Products</a></li>
    <li><a href="/admin/orders.php">Placed Orders</a></li>
    <li><a href="/admin/revenue.php">Revenue</a></li>
  </ul>
</div>

<style>
  .sidebar .logo {
    width: 150px;
    margin-bottom: 20px;
    border-radius: 10px;
  }

  .sidebar {
    width: 18%;
    background-color: var(--light-pink);
    color: var(--dark);
    padding: 20px;
    display: flex;
    flex-direction: column;
    position: fixed;
    /* Sidebar remains fixed */
    top: 0;
    bottom: 0;
    left: 0;
  }


  .sidebar ul {
    list-style-type: none;
    padding: 0;
  }

  .sidebar ul li {
    margin: 20px 0;
  }

  .sidebar ul li a {
    color: #34495e;
    text-decoration: none;
    font-weight: bold;
  }

  .sidebar ul li a:hover {
    text-decoration: underline;
  }

  /* Responsive Design */
  @media (max-width: 768px) {

    .sidebar ul li {
      font-size: 12px;
    }
  }
</style>