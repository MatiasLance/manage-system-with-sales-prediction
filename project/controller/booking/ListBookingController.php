<?php
session_start();
header("Content-Type: application/json");

require_once __DIR__ . '/../../config/db_connection.php';

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$items_per_page = isset($_GET['items_per_page']) ? (int)$_GET['items_per_page'] : 10;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

if ($page < 1) $page = 1;
if ($items_per_page < 1) $items_per_page = 10;
if ($items_per_page > 100) $items_per_page = 50;

$offset = ($page - 1) * $items_per_page;

$search_param = "%$search%";

$sql = "
    SELECT 
        b.id,
        b.first_name,
        b.middle_name,
        b.last_name,
        b.email,
        b.phone_number,
        b.status AS booking_status,
        b.guest_count,
        b.booking_schedule,
        b.check_in,
        b.check_out,
        b.created_at,
        r.room_number,
        r.status AS room_status
    FROM booking b
    LEFT JOIN room r ON b.room_id = r.id
    WHERE b.status != 'cancelled'
      AND (
        r.room_number LIKE ? 
        OR b.first_name LIKE ?
        OR b.last_name LIKE ?
        OR b.email LIKE ?
        OR CONCAT(b.first_name, ' ', b.last_name) LIKE ?
        OR CONCAT(b.last_name, ' ', b.first_name) LIKE ?
      )
    ORDER BY b.booking_schedule DESC, b.created_at DESC
    LIMIT ? OFFSET ?
";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    http_response_code(500);
    echo json_encode([
        "error" => true,
        "message" => "Database prepare error: " . $conn->error
    ]);
    exit;
}

$stmt->bind_param(
    "ssssssii",
    $search_param, $search_param, $search_param,
    $search_param, $search_param, $search_param,
    $items_per_page, $offset
);

$stmt->execute();
$result = $stmt->get_result();
$bookings = [];

while ($row = $result->fetch_assoc()) {
    $row['booking_schedule'] = date('Y-m-d H:i', strtotime($row['booking_schedule']));
    $row['created_at'] = date('Y-m-d H:i', strtotime($row['created_at']));
    $row['full_name'] = trim("{$row['first_name']} {$row['middle_name']} {$row['last_name']}");
    $row['id'] = (int)$row['id'];
    $row['guest_count'] = (int)$row['guest_count'];
    $row['check_in'] = $row['check_in'] ?? '';
    $row['check_out'] = $row['check_out'] ?? '';

    $bookings[] = $row;
}
$stmt->close();

$sql_total = "
    SELECT COUNT(*) AS total
    FROM booking b
    LEFT JOIN room r ON b.room_id = r.id
    WHERE b.status != 'cancelled'
      AND (
        r.room_number LIKE ? 
        OR b.first_name LIKE ?
        OR b.last_name LIKE ?
        OR b.email LIKE ?
        OR CONCAT(b.first_name, ' ', b.last_name) LIKE ?
        OR CONCAT(b.last_name, ' ', b.first_name) LIKE ?
      )
";

$stmt_total = $conn->prepare($sql_total);
$stmt_total->bind_param(
    "ssssss",
    $search_param, $search_param, $search_param,
    $search_param, $search_param, $search_param
);
$stmt_total->execute();
$total_result = $stmt_total->get_result();
$total_row = $total_result->fetch_assoc();
$total_items = (int)($total_row['total']);
$stmt_total->close();

$total_pages = $total_items > 0 ? ceil($total_items / $items_per_page) : 1;

$response = [
    'success' => true,
    'data' => $bookings,
    'pagination' => [
        'current_page' => $page,
        'items_per_page' => $items_per_page,
        'total_pages' => $total_pages,
        'total_items' => $total_items,
        'has_next' => $page < $total_pages,
        'has_prev' => $page > 1
    ],
    'search' => $search
];

http_response_code(200);
echo json_encode($response, JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK);

$conn->close();