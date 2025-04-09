<?php
session_start();

require_once __DIR__ . '/../../config/db_connection.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quantity = $_POST['order_quantity'] ?? 0;
    $name = isset($_POST['order_product_name']) ? (int)$_POST['order_product_name'] : 0;
    $price = $_POST['order_product_price'] ?? 0;
    $unit = trim($_POST['order_product_unit_of_price'] ?? '');
    $total_amount = $_POST['order_total_amount'] ?? 0;

    $errors = [];

    // Validate required fields
    if (!is_numeric($quantity) || $quantity <= 0) $errors[] = "Quantity must be a positive number.";
    if (!is_numeric($price) || $price <= 0) $errors[] = "Price must be a valid positive number.";
    if (empty($unit)) $errors[] = "Unit is required.";


    // If validation fails, return errors
    if (!empty($errors)) {
        echo json_encode(["status" => "error", "message" => $errors]);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO orders (quantity, product_name, price, unit_of_price, total_amount) VALUES (?, ?, ?, ?, ?)");

    if (!$stmt) {
        echo json_encode(["status" => "error", "message" => "Database error: " . $conn->error]);
        exit;
    }

    $stmt->bind_param("isdsd", $quantity, $name, $price, $unit, $total_amount);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Order saved successfully!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error saving order: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
