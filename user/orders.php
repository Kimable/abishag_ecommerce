<?php
$title = 'Orders';
// get all ordsers from the DB
require __DIR__ . '/../util/DB_connect.php';
$conn = connect();

$getAllOrders = "SELECT * FROM orders";

$stmt = $conn->prepare($getAllOrders);
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

require __DIR__ . '/includes/header.php';
?>

<main class="container orders">
  <h1>Orders</h1>
  <table>
    <thead>
      <tr>
        <th>Order ID</th>
        <th>Status</th>
        <th>Total Amount</th>
        <th>View</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($orders as $order) : ?>
        <tr>
          <td>ABI_ORD_<?php echo $order['id'] ?></td>
          <td><?php echo $order['status'] ?></td>
          <td><?php echo $order['total_amount'] ?></td>
          <td><a href="order.php?order_id=<?php echo $order['id'] ?>">View Order</a></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <?php require './includes/footer.php' ?>

  <style>
    .orders {
      margin-top: 1rem;
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

    tr:hover {
      background-color: #f2f2f2;
    }

    @media (max-width: 768px) {
      table {
        overflow-x: auto;
        display: block;
      }

      th,
      td {
        white-space: nowrap;
      }
    }
  </style>