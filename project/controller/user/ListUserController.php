<?php
session_start();
header("Content-Type: application/json");

require_once __DIR__ . '/../../config/db_connection.php';

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$items_per_page = 10;
$search = isset($_GET['search']) ? trim($_GET['search']) : "";

if ($page < 1) $page = 1;
if ($items_per_page < 1) $items_per_page = 10;

$offset = ($page - 1) * $items_per_page;

$search_param = "%$search%";

$sql = "SELECT id, CONCAT(firstname, ' ', lastname) AS full_name, email, user_type
        FROM users 
        WHERE CONCAT(firstname, ' ', lastname) LIKE ? 
        LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode(["error" => true, "message" => "Database error: " . $conn->error]);
    exit;
}

$stmt->bind_param("sii", $search_param, $items_per_page, $offset);
$stmt->execute();
$result = $stmt->get_result();

$employees = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$sql_total = "SELECT COUNT(*) AS total FROM users WHERE CONCAT(firstname, ' ', ' ', lastname) LIKE ?";
$stmt_total = $conn->prepare($sql_total);
$stmt_total->bind_param("s", $search_param);
$stmt_total->execute();
$total_result = $stmt_total->get_result();
$total_row = $total_result->fetch_assoc();
$total_items = $total_row['total'];
$stmt_total->close();

$total_pages = ceil($total_items / $items_per_page);

$response = [
    'data' => $employees,
    'total_pages' => $total_pages,
    'total_users' => $total_items
];

echo json_encode($response, JSON_NUMERIC_CHECK);

$conn->close();
