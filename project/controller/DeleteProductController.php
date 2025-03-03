<?php
session_start();
require_once __DIR__ . '/../config/db_connection.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input data
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    $errors = [];

    // Validate required fields
    if ($id <= 0) {
        $errors[] = "Invalid product ID.";
    }

    // If validation fails, return errors
    if (!empty($errors)) {
        echo json_encode(["status" => "error", "message" => $errors]);
        exit;
    }

    // Check if the product exists before deleting
    $stmt = $conn->prepare("SELECT COUNT(*) FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count === 0) {
        echo json_encode(["success" => false, "message" => "Product not found."]);
        exit;
    }

    // Prepare and execute the delete statement
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    if (!$stmt) {
        echo json_encode(["status" => "error", "message" => "Database error: " . $conn->error]);
        exit;
    }

    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Product deleted successfully!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error deleting product: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
    exit;
}
