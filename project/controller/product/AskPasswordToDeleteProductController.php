<?php
session_start();
require_once __DIR__ . '/../../config/db_connection.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
    exit;
}

// Validate input
if (!isset($_POST['password'], $_POST['id'])) {
    echo json_encode(['success' => false, 'message' => 'Password and product ID are required.']);
    exit;
}

$password = $_POST['password'];
$product_id = (int)$_POST['id'];

if ($product_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid product ID.']);
    exit;
}

// Fetch admin's hashed password
$sql = "SELECT password FROM users WHERE user_type = 'admin' LIMIT 1";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Database query error.']);
    exit;
}

$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($password_db);
    $stmt->fetch();
    $stmt->close();

    // Verify password
    if (!password_verify($password, $password_db)) {
        echo json_encode(['success' => false, 'message' => 'Invalid password.']);
        exit;
    }

    // Start transaction
    $conn->begin_transaction();

    try {
        // Retrieve product details
        $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        $stmt->close();

        if (!$product) {
            throw new Exception("Product not found.");
        }

        // Move product to archived table
        $stmt_archive = $conn->prepare("
            INSERT INTO archived_products 
            (id, quantity, product_name, date_expiration, date_produce, price, unit_of_price, category, status, deleted_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
        ");
        $stmt_archive->bind_param(
            "iisssdsss",
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
        $stmt_archive->execute();

        if ($stmt_archive->affected_rows <= 0) {
            throw new Exception("Failed to archive product.");
        }
        $stmt_archive->close();

        // Delete the product from the products table
        $stmt_delete = $conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt_delete->bind_param("i", $product_id);
        $stmt_delete->execute();

        if ($stmt_delete->affected_rows <= 0) {
            throw new Exception("Failed to delete product.");
        }
        $stmt_delete->close();

        // Commit transaction
        $conn->commit();
        echo json_encode(['success' => true, 'message' => 'Product archived and deleted successfully.']);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Admin user not found.']);
}

$conn->close();
?>
