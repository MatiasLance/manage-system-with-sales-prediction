<?php
session_start();
header("Content-Type: application/json");

require_once __DIR__ . '/../../config/db_connection.php';

if (!isset($_POST['id']) || !is_numeric($_POST['id']) || empty(trim($_POST['product_name'])) || empty(trim($_POST['product_code'])) || empty(trim($_POST['product_category']))) {
    echo json_encode(["error" => true, "message" => "Invalid input data"]);
    exit;
}

$product_id = (int) $_POST['id'];
$product_name = trim($_POST['product_name']);
$product_code = trim($_POST['product_code']);
$product_category = trim($_POST['product_category']);

$check_sql = "SELECT id FROM products_name WHERE product_name = ? AND product_code = ? AND id != ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("ssi", $product_name, $product_code, $product_id);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if ($check_result->num_rows > 0) {
    echo json_encode(["error" => true, "message" => "Product name or code already exists"]);
    $check_stmt->close();
    exit;
}
$check_stmt->close();

$update_sql = "UPDATE products_name SET product_name = ?, product_code = ?, product_category = ? WHERE id = ?";
$update_stmt = $conn->prepare($update_sql);

if (!$update_stmt) {
    echo json_encode(["error" => true, "message" => "Database error: " . $conn->error]);
    exit;
}

$update_stmt->bind_param("sssi", $product_name, $product_code, $product_category, $product_id);

if ($update_stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Product updated successfully"]);
} else {
    echo json_encode(["error" => true, "message" => "Failed to update product"]);
}

$update_stmt->close();
$conn->close();
?>
