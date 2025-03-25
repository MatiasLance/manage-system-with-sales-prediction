<?php
session_start();
require_once __DIR__ . '/../../config/db_connection.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input data
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $quantity = isset($_POST['product_quantity']) && is_numeric($_POST['product_quantity']) ? (int)$_POST['product_quantity'] : 0;
    $name = trim($_POST['product_name'] ?? '');
    $date_produce = $_POST['product_date_produce'] ?? '';
    $date_expiration = $_POST['product_date_expiration'] ?? '';
    $price = isset($_POST['product_price']) && is_numeric($_POST['product_price']) ? (float)$_POST['product_price'] : 0;
    $unit = trim($_POST['product_unit_of_price'] ?? '');
    $category = trim($_POST['product_category'] ?? '');

    $errors = [];

    // Validate required fields
    if ($id <= 0) $errors[] = "Invalid product ID.";
    if (empty($name)) $errors[] = "Product name is required.";
    if ($quantity <= 0) $errors[] = "Quantity must be a positive number.";
    if (empty($date_produce)) $errors[] = "Production date is required.";
    if (empty($date_expiration)) $errors[] = "Expiration date is required.";
    if ($price <= 0) $errors[] = "Price must be a valid positive number.";
    if (empty($unit)) $errors[] = "Unit is required.";
    if(empty($category)) $errors[] = "Category is required";

    // Validate date format
    if (!empty($date_produce) && !empty($date_expiration)) {
        if (strtotime($date_produce) > strtotime($date_expiration)) {
            $errors[] = "Production date cannot be after expiration date.";
        }
    }

    // If validation fails, return errors
    if (!empty($errors)) {
        echo json_encode(["status" => "error", "message" => $errors]);
        exit;
    }

    // Prepare and execute the update statement
    $stmt = $conn->prepare("UPDATE products SET quantity = ?, product_name = ?, date_produce = ?, date_expiration = ?, price = ?, unit_of_price = ?, category = ? WHERE id = ?");
    
    if (!$stmt) {
        echo json_encode(["status" => "error", "message" => "Database error: " . $conn->error]);
        exit;
    }

    $stmt->bind_param("isssdssi", $quantity, $name, $date_produce, $date_expiration, $price, $unit, $category, $id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Product updated successfully!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error updating product: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
