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
        echo json_encode(["error" => true, "message" => "Product category is required."]);
        exit;
    }

    $checkStmt = $conn->prepare("SELECT COUNT(*) AS count FROM products_name WHERE product_code = ?");
    if (!$checkStmt) {
        echo json_encode(["error" => true, "message" => "Database error: " . $conn->error]);
        exit;
    }

    $checkStmt->bind_param("s", $code);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['count'] > 0) {
        echo json_encode(["error" => true, "message" => "Product code already exists. Please use a unique product code."]);
        $checkStmt->close();
        $conn->close();
        exit;
    }

    $checkStmt->close();

    $insertStmt = $conn->prepare("INSERT INTO products_name (product_name, product_code, product_category) VALUES (?, ?, ?)");
    if (!$insertStmt) {
        echo json_encode(["error" => true, "message" => "Database error: " . $conn->error]);
        exit;
    }

    $insertStmt->bind_param("sss", $name, $code, $category);

    if ($insertStmt->execute()) {
        echo json_encode(["success" => true, "message" => "Product saved successfully!"]);
    } else {
        echo json_encode(["error" => true, "message" => "Error saving product: " . $insertStmt->error]);
    }

    $insertStmt->close();
    $conn->close();
}