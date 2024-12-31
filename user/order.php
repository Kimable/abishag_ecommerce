<?php
$title = "Order";
// Show a single order based on the order_id. Path: user/order.php?order_id=id

require __DIR__ . '/../util/DB_connect.php';
$conn = connect();

if (!isset($_GET['order_id'])) {
  echo "No order ID provided";
  exit;
}

$order_id = $_GET['order_id'];

// get all products in the order with the order_id and then get the product name, price, quantity from the products table

$sql = "SELECT op.product_id, op.quantity, op.price, p.name, p.price FROM order_products op JOIN products p ON op.product_id = p.id WHERE op.order_id = :order_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':order_id', $order_id);
$stmt->execute();
$order_products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// get the order status from the orders table
$order_status = "SELECT status FROM orders WHERE id = :order_id";
$stmt = $conn->prepare($order_status);
$stmt->bindParam(':order_id', $order_id);
$stmt->execute();
$status = $stmt->fetch(PDO::FETCH_ASSOC);




if (!$order_products) {
  echo "Order not found";
  exit;
}

require __DIR__ . '/includes/header.php';
?>

<main class="container order">
  <h1 style="margin-bottom: 1rem;">Order Details</h1>
  <table>
    <thead>
      <tr>
        <th>Product Name</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $total = 0;
      foreach ($order_products as $product) :
        $total += $product['price'] * $product['quantity'];
      ?>
        <tr>
          <td><?php echo $product['name'] ?></td>
          <td><?php echo $product['price'] ?></td>
          <td><?php echo $product['quantity'] ?></td>
          <td><?php echo $product['price'] * $product['quantity'] ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <p style="margin: 1rem 0;">Order Total: <span style="color:var(--purple); font-weight:800">KES <?php echo $total ?></span></p>
  <?php $pending = 'yellow';
  $completed = 'green'; ?>
  <p style="margin: 1rem 0; ">Order Status: <span class="<?php echo $status['status'] == 'pending' ? $pending  : $completed ?>"><?php echo ucfirst($status['status']) ?></span></p>

  <?php if ($status['status'] != 'completed') { ?>
    <a href='/user/pay.php' class='btn'>Make Payment</a>
    <a href='/user/cancel.php' class='btn' style="background-color: gray;">Cancel Order</a>
  <?php } ?>
</main>

<style>
  .order {
    margin-top: 1rem;
    margin-bottom: 1rem;
  }

  table {
    width: 100%;
    border-collapse: collapse;
  }

  th,
  td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
  }

  th {
    background-color: var(--purple);
    color: white;
  }

  tr:nth-child(even) {
    background-color: var(--light-purple);
  }

  @media (max-width: 768px) {
    table {
      overflow-x: auto;
      display: block;
    }

    th,
    td {
      padding: 5px;
      white-space: wrap;
    }
  }

  /* Order Status */
  .yellow {
    background-color: yellow;
    padding: 0.5rem 1rem;
    border-radius: 5px;
  }

  .green {
    background-color: green;
    padding: 0.5rem 1rem;
    border-radius: 5px;
    color: white;
  }
</style>


<?php require './includes/footer.php' ?>