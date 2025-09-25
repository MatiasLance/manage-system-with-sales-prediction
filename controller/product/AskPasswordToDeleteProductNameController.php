<?php
session_start();
require_once __DIR__ . '/../../config/db_connection.php';

header('Content-Type: application/json');

if (!isset($_POST['password'], $_POST['id'])) {
    echo json_encode(['success' => false, 'message' => 'Password and product name ID are required.']);
    exit;
}

$password = $_POST['password'];
$product_name_id = (int)$_POST['id'];

// Get admin password
$sql = "SELECT password FROM users WHERE user_type = 'admin' LIMIT 1";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode(['error' => true, 'message' => 'Error preparing query.']);
    exit;
}

$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    echo json_encode(['error' => true, 'message' => 'Admin user not found.']);
    $stmt->close();
    exit;
}

$stmt->bind_result($password_db);
$stmt->fetch();
$stmt->close();

if (!password_verify($password, $password_db)) {
    echo json_encode(['error' => true, 'message' => 'Invalid password.']);
    exit;
}

// Check if the product_name_id is used in products or archived_products
$check_sql = "
    SELECT 
        (SELECT COUNT(*) FROM products WHERE product_name_id = ?) AS used_in_products,
        (SELECT COUNT(*) FROM archived_products WHERE product_name_id = ?) AS used_in_archived
";

$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("ii", $product_name_id, $product_name_id);
$check_stmt->execute();
$check_stmt->bind_result($used_in_products, $used_in_archived);
$check_stmt->fetch();
$check_stmt->close();

if ($used_in_products > 0 || $used_in_archived > 0) {
    echo json_encode([
        'error' => true,
        'message' => 'Cannot delete this product name. It is still being used in active or archived products.'
    ]);
    exit;
}

// Safe to delete
$delete_stmt = $conn->prepare("DELETE FROM products_name WHERE id = ?");
$delete_stmt->bind_param("i", $product_name_id);

if ($delete_stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Product name deleted successfully.']);
} else {
    echo json_encode(['error' => true, 'message' => 'Failed to delete product name.']);
}

$delete_stmt->close();
$conn->close();
?>
