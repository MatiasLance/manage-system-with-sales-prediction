<?php
session_start();

require_once __DIR__ . '/../config/db_connection.php';

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405);
    echo json_encode([
        "error" => true,
        "message" => "Method not allowed"
    ]);
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id']) || intval($_GET['id']) <= 0) {
    http_response_code(400);
    echo json_encode([
        "error" => true,
        "message" => "Valid order ID is required"
    ]);
    exit;
}

$id = intval($_GET['id']);

$sql = "
    SELECT 
        id,
        order_number,
        quantity,
        product_name,
        price,
        unit_of_price,
        tax_amount,
        total,
        created_at
    FROM orders 
    WHERE id = ?
";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    http_response_code(500);
    echo json_encode([
        "error" => true,
        "message" => "Internal server error: failed to prepare query"
    ]);
    exit;
}

$stmt->bind_param("i", $id);

if (!$stmt->execute()) {
    http_response_code(500);
    echo json_encode([
        "error" => true,
        "message" => "Failed to execute query"
    ]);
    $stmt->close();
    $conn->close();
    exit;
}

$result = $stmt->get_result();
$order = $result->fetch_assoc();

if (!$order) {
    http_response_code(404);
    echo json_encode([
        "error" => true,
        "message" => "No order found with the given ID"
    ]);
} elseif ($order['deleted_at'] !== null) {
    http_response_code(404);
    echo json_encode([
        "error" => true,
        "message" => "Order has been deleted"
    ]);
} else {
    echo json_encode([
        "success" => true,
        "order" => [
            "id"              => (int)$order['id'],
            "order_number"    => $order['order_number'],
            "quantity"        => (int)$order['quantity'],
            "product_name"    => $order['product_name'],
            "price"           => (float)$order['price'],
            "unit_of_price"   => $order['unit_of_price'],
            "tax_amount"      => (float)$order['tax_amount'],
            "total"           => (float)$order['total'],
            "created_at"      => $order['created_at']
        ]
    ], JSON_NUMERIC_CHECK);
}
$stmt->close();
$conn->close();