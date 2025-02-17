<?php
session_start();

require_once __DIR__ . '/../config/db_connection.php';

// Get the page number and search query
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$items_per_page = 5; // Number of items per page
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : "";

// Calculate offset
$offset = ($page - 1) * $items_per_page;

// Query for fetching data with search filter
$sql = "SELECT * FROM products WHERE name LIKE '%$search%' LIMIT $items_per_page OFFSET $offset";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Get total number of records for pagination
$sql_total = "SELECT COUNT(*) AS total FROM products WHERE name LIKE '%$search%'";
$total_result = $conn->query($sql_total);
$total_row = $total_result->fetch_assoc();
$total_items = $total_row['total'];
$total_pages = ceil($total_items / $items_per_page);

// Prepare response
$response = [
    'data' => $data,
    'total_pages' => $total_pages
];

echo json_encode($response);

$conn->close();