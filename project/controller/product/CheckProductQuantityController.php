<?php
session_start();

require_once __DIR__ . '/../../config/db_connection.php';
require_once __DIR__ . '/../../helper/helper.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed.']);
    exit;
}

$response = ['status' => 'error', 'message' => ''];

try {
    $id = isset($_POST['id']) ? filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT) : null;
    $name = trim($_POST['name'] ?? '');
    $quantity = isset($_POST['quantity']) ? filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT) : 0;

    $errors = [];

    if ($id === null || $id <= 0) {
        $errors[] = "Invalid product ID.";
    }
    if ($quantity === null || $quantity <= 0) {
        $errors[] = "Quantity must be a positive integer.";
    }
    if (empty($name)) {
        $errors[] = "Product name is required.";
    }

    if (!empty($errors)) {
        echo json_encode(['status' => 'error', 'message' => $errors]);
        exit;
    }

    $stmt = $conn->prepare("SELECT total_quantity FROM products WHERE id = ?");
    if (!$stmt) {
        throw new Exception("Failed to prepare statement.");
    }

    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if (!$result) {
        echo json_encode(['status' => 'error', 'message' => 'Product not found.']);
        exit;
    }

    $productStock = (int) $result['total_quantity'];

    if ($quantity > $productStock) {
        echo json_encode([
            'status' => 'error',
            'message' => "Insufficient stock for product: $name. Available: $productStock, Requested: $quantity"
        ]);
        exit;
    }

} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'An internal error occurred. Please try again.'
    ]);
} finally {

    if (isset($stmt) && $stmt instanceof mysqli_stmt) {
        $stmt->close();
    }
    if (isset($conn)) {
        $conn->close();
    }
}