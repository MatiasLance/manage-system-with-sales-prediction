<?php
session_start();
require_once __DIR__ . '/../../config/db_connection.php';

header('Content-Type: application/json');

// Check if password and product ID are provided
if (!isset($_POST['password'], $_POST['id'])) {
    echo json_encode(['success' => false, 'message' => 'Password and product ID are required.']);
    exit;
}

$password = $_POST['password'];
$product_id = $_POST['id'];

// Get the admin's hashed password from the database
$sql = "SELECT password FROM users WHERE user_type = 'admin' LIMIT 1";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($password_db);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $password_db)) {
            // Password is correct, proceed with product deletion
            $deleteSql = "DELETE FROM products WHERE id = ?";
            $deleteStmt = $conn->prepare($deleteSql);

            if ($deleteStmt) {
                $deleteStmt->bind_param("i", $product_id);
                if ($deleteStmt->execute()) {
                    echo json_encode(['success' => true, 'message' => 'Product deleted successfully.']);
                } else {
                    echo json_encode(['error' => true, 'message' => 'Failed to delete product.']);
                }
                $deleteStmt->close();
            } else {
                echo json_encode(['error' => true, 'message' => 'Error preparing delete query.']);
            }
        } else {
            echo json_encode(['error' => true, 'message' => 'Invalid password.']);
        }
    } else {
        echo json_encode(['error' => true, 'message' => 'Admin user not found.']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => true, 'message' => 'Error preparing query.']);
}

$conn->close();
?>
