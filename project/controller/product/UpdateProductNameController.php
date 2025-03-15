<?php
session_start();
header("Content-Type: application/json");

require_once __DIR__ . '/../../config/db_connection.php';

// Validate input
if (!isset($_POST['id']) || !is_numeric($_POST['id']) || empty(trim($_POST['product_name']))) {
    echo json_encode(["error" => true, "message" => "Invalid input data"]);
    exit;
}

$product_id = (int) $_POST['id']; // Convert ID to integer
$product_name = trim($_POST['product_name']); // Trim input to remove extra spaces

// Check if product name already exists
$check_sql = "SELECT id FROM products_name WHERE product_name = ? AND id != ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("si", $product_name, $product_id);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if ($check_result->num_rows > 0) {
    echo json_encode(["error" => true, "message" => "Product name already exists"]);
    $check_stmt->close();
    exit;
}
$check_stmt->close();

// Prepare update query using prepared statement
$update_sql = "UPDATE products_name SET product_name = ? WHERE id = ?";
$update_stmt = $conn->prepare($update_sql);

if (!$update_stmt) {
    echo json_encode(["error" => true, "message" => "Database error: " . $conn->error]);
    exit;
}

$update_stmt->bind_param("si", $product_name, $product_id);

if ($update_stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Product updated successfully"]);
} else {
    echo json_encode(["error" => true, "message" => "Failed to update product"]);
}

$update_stmt->close();
$conn->close();
?>
