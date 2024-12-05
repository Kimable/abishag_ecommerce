<?php
require './util/DB_connect.php';

// Pagination logic
$limit = 10;  // Number of items per page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// SQL query to get data with limit and offset for pagination
$conn = connect();
$sql = "SELECT p.id, p.name, p.price, p.offer_price, p.slug, GROUP_CONCAT(i.image_path) AS images, i.main
FROM products AS p 
LEFT JOIN product_images AS i ON p.id = i.product_id 
GROUP BY p.id 
ORDER BY p.createdAt DESC 
LIMIT :limit OFFSET :offset
";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Count total number of records for pagination
$total = $conn->query("SELECT COUNT(*) FROM products")->fetchColumn();
$total_pages = ceil($total / $limit);
