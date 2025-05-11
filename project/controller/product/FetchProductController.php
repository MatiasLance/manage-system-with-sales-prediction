<?php
session_start();
header("Content-Type: application/json");

require_once __DIR__ . '/../../config/db_connection.php';

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$items_per_page = 10;
$search = isset($_GET['search']) ? trim($_GET['search']) : "";

if ($page < 1) $page = 1;

$offset = ($page - 1) * $items_per_page;

$search_param = "%$search%";

$sql = "SELECT p.*, pn.product_name, pn.product_code, pn.product_category
        FROM products p
        INNER JOIN products_name pn ON p.product_name_id = pn.id
        WHERE pn.product_name LIKE ? OR pn.product_code LIKE ?
        LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode(["error" => true, "message" => "Database error: " . $conn->error]);
    exit;
}

$stmt->bind_param("ssii", $search_param, $search_param, $items_per_page, $offset);
$stmt->execute();
$result = $stmt->get_result(); 

$data = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$sql_total = "SELECT COUNT(*) AS total 
              FROM products p
              INNER JOIN products_name pn ON p.product_name_id = pn.id
              WHERE pn.product_name LIKE ? OR pn.product_code LIKE ?";
$stmt_total = $conn->prepare($sql_total);

if (!$stmt_total) {
    echo json_encode(["error" => true, "message" => "Database error: " . $conn->error]);
    exit;
}

$stmt_total->bind_param("ss", $search_param, $search_param);
$stmt_total->execute();
$total_result = $stmt_total->get_result();
$total_row = $total_result->fetch_assoc();
$total_items = $total_row ? $total_row['total'] : 0;
$stmt_total->close();

$total_pages = ($total_items > 0) ? ceil($total_items / $items_per_page) : 1;

$response = [
    'success' => true,
    'data' => $data,
    'total_pages' => $total_pages,
    'total_products' => $total_items
];

echo json_encode($response, JSON_NUMERIC_CHECK);

$conn->close();
?>
