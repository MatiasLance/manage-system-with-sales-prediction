<?php
session_start();
require_once __DIR__ . '/../../config/db_connection.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input data
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    $errors = [];

    if ($id <= 0) {
        $errors[] = "Invalid product ID.";
    }

    if (!empty($errors)) {
        echo json_encode(["status" => "error", "message" => $errors]);
        exit;
    }

    // Start transaction
    $conn->begin_transaction();

    try {
        // Retrieve product details
        $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        $stmt->close();

        if (!$product) {
            echo json_encode(["success" => false, "message" => "Product not found."]);
            exit;
        }

        // Move product to archived_products
        $stmt = $conn->prepare("INSERT INTO archived_products 
            (id, quantity, product_name, date_expiration, date_produce, price, unit_of_price, category, status, deleted_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param(
            "iissdssss",
            $product['id'],
            $product['quantity'],
            $product['product_name'],
            $product['date_expiration'],
            $product['date_produce'],
            $product['price'],
            $product['unit_of_price'],
            $product['category'],
            $product['status']
        );
        $stmt->execute();
        $stmt->close();

        // Delete the product from the products table
        $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();

        // Commit transaction
        $conn->commit();

        echo json_encode(["success" => true, "message" => "Product archived successfully!"]);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
    }

    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
?>
