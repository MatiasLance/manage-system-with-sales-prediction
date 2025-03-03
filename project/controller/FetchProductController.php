<?php
session_start();
header("Content-Type: application/json");

require_once __DIR__ . '/../config/db_connection.php';

// Get the page number and search query
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$items_per_page = 5; // Number of items per page
$search = isset($_GET['search']) ? $_GET['search'] : "";

// Calculate offset
$offset = ($page - 1) * $items_per_page;

// Modify search query to match any part of product_name
$search_param = "%$search%";

// Prepare the SQL query to fetch data
$sql = "SELECT * FROM products WHERE product_name LIKE ? LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sii", $search_param, $items_per_page, $offset);
$stmt->execute();
$result = $stmt->get_result();

// Fetch data into an array
$data = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Prepare the SQL query to count total records
$sql_total = "SELECT COUNT(*) AS total FROM products WHERE product_name LIKE ?";
$stmt_total = $conn->prepare($sql_total);
$stmt_total->bind_param("s", $search_param);
$stmt_total->execute();
$total_result = $stmt_total->get_result();
$total_row = $total_result->fetch_assoc();
$total_items = $total_row['total'];
$stmt_total->close();

// Calculate total pages
$total_pages = ceil($total_items / $items_per_page);

// Prepare response
$response = [
    'data' => $data,
    'total_pages' => $total_pages,
    'total_products' => $total_items
];

// Send JSON response
echo json_encode($response, JSON_NUMERIC_CHECK);

$conn->close();
?>
