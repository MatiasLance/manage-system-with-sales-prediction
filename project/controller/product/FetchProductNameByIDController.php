<?php
session_start();
header("Content-Type: application/json");

require_once __DIR__ . '/../../config/db_connection.php';

// Check if product ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo json_encode(["error" => true, "message" => "Invalid product ID"]);
    exit;
}

$product_id = (int) $_GET['id']; // Convert ID to integer for safety

// Prepare SQL query using prepared statement
$sql = "SELECT id, product_name FROM products_name WHERE id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode(["error" => true, "message" => "Database error: " . $conn->error]);
    exit;
}

$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

// Fetch the product name
if ($row = $result->fetch_assoc()) {
    echo json_encode(["success" => true, "product" => $row], JSON_NUMERIC_CHECK);
} else {
    echo json_encode(["error" => true, "message" => "Product not found"]);
}

$stmt->close();
$conn->close();
?>
