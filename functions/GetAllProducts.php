<?php
require __DIR__ . '/../util/DB_connect.php';

// Pagination logic
$limit = 10; // Number of items per page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Connect to database
$conn = connect();

// Prepare query criteria
$loading = true;
$criteria = [];
$params = [];

// Example criteria: price range, category, keyword
if (isset($_GET['min_price']) && is_numeric($_GET['min_price'])) {
  $criteria[] = "p.price >= :min_price";
  $params[':min_price'] = $_GET['min_price'];
}

if (isset($_GET['max_price']) && is_numeric($_GET['max_price'])) {
  $criteria[] = "p.price <= :max_price";
  $params[':max_price'] = $_GET['max_price'];
}

if (isset($_GET['category']) && !empty($_GET['category'])) {
  $criteria[] = "p.category = :category";
  $params[':category'] = $_GET['category'];
}

if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
  $criteria[] = "(p.name LIKE :keyword OR p.description LIKE :keyword)";
  $params[':keyword'] = '%' . $_GET['keyword'] . '%';
}

// Build the WHERE clause
$whereClause = !empty($criteria) ? 'WHERE ' . implode(' AND ', $criteria) : '';

// SQL query to get products with main or first image
$sql = "SELECT 
        p.id, 
        p.name, 
        p.price, 
        p.offer_price,  
        p.slug,
        p.archive,
        p.out_of_stock,
        COALESCE(
            (SELECT i.image_path FROM product_images AS i WHERE i.product_id = p.id AND i.main = 1 LIMIT 1),
            (SELECT i.image_path FROM product_images AS i WHERE i.product_id = p.id LIMIT 1)
        ) AS main_image
    FROM products AS p
    $whereClause
    ORDER BY p.createdAt DESC
    LIMIT :limit OFFSET :offset
";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

// Bind additional criteria parameters
foreach ($params as $key => $value) {
  $stmt->bindValue($key, $value, is_numeric($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
}

// Execute query and fetch results
$stmt->execute();
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Count total number of records for pagination
$countSql = "SELECT COUNT(*) FROM products AS p $whereClause";
$countStmt = $conn->prepare($countSql);
foreach ($params as $key => $value) {
  $countStmt->bindValue($key, $value, is_numeric($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
}
$countStmt->execute();
$total = $countStmt->fetchColumn();
$total_pages = ceil($total / $limit);
$loading = false;
