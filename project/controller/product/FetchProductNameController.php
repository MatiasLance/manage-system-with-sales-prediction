<?php
session_start();
header("Content-Type: application/json");

require_once __DIR__ . '/../../config/db_connection.php';

// Get the page number and items per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$items_per_page = 10;
$search = isset($_GET['search']) ? trim($_GET['search']) : "";

// Ensure page and items per page are valid
if ($page < 1) $page = 1;
if ($items_per_page < 1) $items_per_page = 10;

// Calculate offset
$offset = ($page - 1) * $items_per_page;

// Modify search query to match any part of product_name
$search_param = "%$search%";

// Prepare the SQL query to fetch data with pagination and search
$sql = "SELECT id, product_name, product_code FROM products_name WHERE product_name LIKE ? OR product_code LIKE ? LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode(["error" => true, "message" => "Database error: " . $conn->error]);
    exit;
}

$stmt->bind_param("ssii", $search_param, $search_param,$items_per_page, $offset);
$stmt->execute();
$result = $stmt->get_result();

// Fetch data into an array
$product_names = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Prepare the SQL query to count total records
$sql_total = "SELECT COUNT(*) AS total FROM products_name WHERE product_name LIKE ? OR product_code LIKE ?";
$stmt_total = $conn->prepare($sql_total);
$stmt_total->bind_param("ss", $search_param, $search_param);
$stmt_total->execute();
$total_result = $stmt_total->get_result();
$total_row = $total_result->fetch_assoc();
$total_items = $total_row['total'];
$stmt_total->close();

// Calculate total pages
$total_pages = ceil($total_items / $items_per_page);

// Prepare response
$response = [
    "success" => true,
    "product_names" => $product_names,
    "total_pages" => $total_pages,
    "total_products" => $total_items
];

// Send JSON response
echo json_encode($response, JSON_NUMERIC_CHECK);

$conn->close();
?>
