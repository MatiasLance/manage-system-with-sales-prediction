<?php
session_start();
require_once __DIR__ . '/../config/db_connection.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $product_name = trim($_POST['product_name'] ?? '');

    if (empty($product_name)) {
        echo json_encode(["error" => true, "message" => "Product name is required."]);
        exit;
    }

    // Prepare the SQL query
    $stmt = $conn->prepare("INSERT INTO products_name (product_name) VALUES (?)");

    if (!$stmt) {
        echo json_encode(["error" => true, "message" => "Database error: " . $conn->error]);
        exit;
    }

    // Bind parameters and execute the query
    $stmt->bind_param("s", $product_name);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Product saved successfully!"]);
    } else {
        echo json_encode(["error" => true, "message" => "Error saving product: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
