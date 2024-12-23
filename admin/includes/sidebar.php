<div class="sidebar">
  <a href="/admin/"><img class="logo" src="../../assets/images/abishag-logo.png" alt="Logo"></a>
  <ul>
    <li><a href="/admin/add-product.php"><img src="/assets/images/icons/add_box.png" alt=""><span>Add Product</span></a></li>
    <li><a href="/admin/manage-products.php"><img src="/assets/images/icons/bookmark_manager.png" alt=""><span>Manage Products</span></a></li>
    <li><a href="/admin/orders.php"><img src="/assets/images/icons/orders.png" alt=""><span>Placed Orders</span></a></li>
    <li><a href="/admin/revenue.php"><img src="/assets/images/icons/finance.png" alt=""><span>Revenue</span></a></li>
  </ul>
</div>

<style>
  .sidebar .logo {
    width: 150px;
    margin-bottom: 20px;

  }

  .sidebar {
    width: 18%;
    background-color: var(--purple);
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

  .sidebar ul li a {
    margin: 20px 0;
    display: flex;
    align-items: center;

  }

  .sidebar ul li img {
    width: 30px;
    margin-right: 10px;
  }

  .sidebar ul li a {
    color: #fff;
    text-decoration: none;
    font-weight: bold;
  }

  .sidebar ul li a:hover {
    text-decoration: underline;
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    .sidebar .logo {
      width: 200px;
      margin-bottom: 20px;
    }

    .sidebar ul li {
      font-size: 12px;
    }
  }

  @media (max-width:600px) {
    .sidebar ul li a span {
      display: none;
    }
  }
</style>