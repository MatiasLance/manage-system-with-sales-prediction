<?php
session_start();
require_once __DIR__ . '/../../config/db_connection.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
    exit;
}

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

$sql = "SELECT password FROM users WHERE user_type = 'admin' LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Admin user not found.']);
    exit;
}

$stmt->bind_result($hashed_password);
$stmt->fetch();
$stmt->close();

if (!password_verify($password, $hashed_password)) {
    echo json_encode(['success' => false, 'message' => 'Invalid password.']);
    exit;
}

$conn->begin_transaction();

try {
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $stmt->close();

    if (!$product) {
        throw new Exception("Product not found.");
    }

    $stmt = $conn->prepare("
        INSERT INTO archived_products (
            id, total_quantity, added_quantity, product_name_id,
            date_produce, date_expiration, price, unit_of_price,
            status, created_at, updated_at, deleted_at
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
    ");

    $stmt->bind_param(
        "iiiississss",
        $product['id'],
        $product['total_quantity'],
        $product['added_quantity'],
        $product['product_name_id'],
        $product['date_produce'],
        $product['date_expiration'],
        $product['price'],
        $product['unit_of_price'],
        $product['status'],
        $product['created_at'],
        $product['updated_at']
    );

    $stmt->execute();

    if ($stmt->affected_rows <= 0) {
        throw new Exception("Failed to archive product.");
    }
    $stmt->close();

    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();

    if ($stmt->affected_rows <= 0) {
        throw new Exception("Failed to delete product.");
    }
    $stmt->close();

    $conn->commit();
    echo json_encode(['success' => true, 'message' => 'Product archived successfully.']);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$conn->close();