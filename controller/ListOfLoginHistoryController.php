<?php
session_start();
header("Content-Type: application/json");

require_once __DIR__ . '/../config/db_connection.php';

$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$items_per_page = 10;
$search = isset($_GET['search']) ? trim($_GET['search']) : "";

$offset = ($page - 1) * $items_per_page;
$search_param = "%$search%";

$sql = "
    SELECT
        u.*,
        lh.id,
        lh.user_id,
        lh.user_agent,
        lh.status,
        lh.created_at,
        lh.updated_at
    FROM login_history lh
    LEFT JOIN users u ON lh.user_id = u.id
    WHERE (
        u.firstname LIKE ?
        OR u.lastname LIKE ?
        OR u.email LIKE ?
        OR lh.user_agent LIKE ?
        OR lh.status LIKE ?
        OR CAST(lh.user_id AS CHAR) LIKE ?
    )
    ORDER BY lh.created_at DESC
    LIMIT ? OFFSET ?
";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "ssssssii",
    $search_param,
    $search_param,
    $search_param,
    $search_param,
    $search_param,
    $search_param,
    $items_per_page,
    $offset
);

$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$sql_total = "
    SELECT COUNT(*) AS total 
    FROM login_history lh
    LEFT JOIN users u ON lh.user_id = u.id
    WHERE (
        u.firstname LIKE ?
        OR u.lastname LIKE ?
        OR u.email LIKE ?
        OR lh.user_agent LIKE ?
        OR lh.status LIKE ?
        OR CAST(lh.user_id AS CHAR) LIKE ?
    )
";

$stmt_total = $conn->prepare($sql_total);
$stmt_total->bind_param(
    "ssssss",
    $search_param,
    $search_param,
    $search_param,
    $search_param,
    $search_param,
    $search_param
);
$stmt_total->execute();
$total_result = $stmt_total->get_result();
$total_row = $total_result->fetch_assoc();
$total_items = $total_row['total'];
$stmt_total->close();

$total_pages = ceil($total_items / $items_per_page);

$response = [
    'data' => $data,
    'total_pages' => $total_pages,
    'total_items' => $total_items,
    'current_page' => $page,
    'items_per_page' => $items_per_page,
    'search' => $search
];

echo json_encode($response, JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT);
$conn->close();