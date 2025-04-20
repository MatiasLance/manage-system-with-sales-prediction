<?php
session_start();
header("Content-Type: application/json");

require_once __DIR__ . '/../../config/db_connection.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo json_encode(["error" => true, "message" => "Invalid product ID"]);
    exit;
}

$product_id = (int) $_GET['id'];

$sql = "SELECT id, product_name, product_code, product_category FROM products_name WHERE id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode(["error" => true, "message" => "Database error: " . $conn->error]);
    exit;
}

$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode(["success" => true, "product" => $row], JSON_NUMERIC_CHECK);
} else {
    echo json_encode(["error" => true, "message" => "Product not found"]);
}

$stmt->close();
$conn->close();
?>
