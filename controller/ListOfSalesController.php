<?php
session_start();

require_once __DIR__ . '/../config/db_connection.php';

header("Content-Type: application/json");

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$items_per_page = 10;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

if ($page < 1) $page = 1;
$offset = ($page - 1) * $items_per_page;

$search_param = "%$search%";

$sql = "SELECT id, order_number, quantity, product_name, price, unit_of_price, tax_amount, total, created_at
        FROM orders
        WHERE deleted_at IS NULL
          AND (order_number LIKE ? OR product_name LIKE ?)
        ORDER BY created_at DESC
        LIMIT ? OFFSET ?";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    http_response_code(500);
    echo json_encode(["error" => true, "message" => "Database prepare error: " . $conn->error]);
    exit;
}

$stmt->bind_param("ssii", $search_param, $search_param, $items_per_page, $offset);
$stmt->execute();
$result = $stmt->get_result();

$data = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$sql_count = "SELECT COUNT(*) AS total, SUM(total) AS sum_amount
              FROM orders
              WHERE deleted_at IS NULL
                AND (order_number LIKE ? OR product_name LIKE ?)";

$stmt_count = $conn->prepare($sql_count);
if (!$stmt_count) {
    http_response_code(500);
    echo json_encode(["error" => true, "message" => "Count query prepare failed: " . $conn->error]);
    exit;
}

$stmt_count->bind_param("ss", $search_param, $search_param);
$stmt_count->execute();
$count_result = $stmt_count->get_result();
$row = $count_result->fetch_assoc();
$total_items = (int)($row['total']);
$total_amount = $row['sum_amount'] !== null ? (float)$row['sum_amount'] : 0.0;
$stmt_count->close();

$total_pages = $total_items > 0 ? ceil($total_items / $items_per_page) : 1;

$total_amount_formatted = number_format($total_amount, 2, '.', '');

$response = [
    'success' => true,
    'data' => $data,
    'pagination' => [
        'current_page' => $page,
        'items_per_page' => $items_per_page,
        'total_pages' => $total_pages,
        'total_orders' => $total_items,
        'has_next' => $page < $total_pages,
        'has_prev' => $page > 1
    ],
    'total_amount' => (float)$total_amount,
    'search' => $search
];

http_response_code(200);
echo json_encode($response, JSON_NUMERIC_CHECK);

$conn->close();