<?php
session_start();
require_once __DIR__ . '/../../config/db_connection.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['product_name'] ?? '');
    $code = trim($_POST['product_code'] ?? '');
    $category = trim($_POST['product_category'] ?? '');

    if (empty($name)) {
        echo json_encode(["error" => true, "message" => "Product name is required."]);
        exit;
    }

    if (empty($code)) {
        echo json_encode(["error" => true, "message" => "Product code is required."]);
        exit;
    }

    if (empty($category)) {
        echo json_encode(["error" => true, "message" => "Product code is required."]);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO products_name (product_name, product_code, product_category) VALUES (?, ?, ?)");

    if (!$stmt) {
        echo json_encode(["error" => true, "message" => "Database error: " . $conn->error]);
        exit;
    }

    $stmt->bind_param("sss", $name, $code, $category);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Product saved successfully!"]);
    } else {
        echo json_encode(["error" => true, "message" => "Error saving product: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
