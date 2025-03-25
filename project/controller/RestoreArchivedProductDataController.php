<?php
session_start();
require_once __DIR__ . '/../config/db_connection.php';

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
            // Start transaction
            $conn->begin_transaction();

            try {
                // Restore product to main table
                $sql_restore = "INSERT INTO products 
                                (id, quantity, product_name, date_expiration, date_produce, price, unit_of_price, category, status)
                                SELECT id, quantity, product_name, date_expiration, date_produce, price, unit_of_price, category, status
                                FROM archived_products WHERE id = ?";
                $stmt_restore = $conn->prepare($sql_restore);
                $stmt_restore->bind_param("i", $product_id);
                $stmt_restore->execute();

                if ($stmt_restore->affected_rows > 0) {
                    // Delete from archive table
                    $sql_delete = "DELETE FROM archived_products WHERE id = ?";
                    $stmt_delete = $conn->prepare($sql_delete);
                    $stmt_delete->bind_param("i", $product_id);
                    $stmt_delete->execute();

                    if ($stmt_delete->affected_rows > 0) {
                        $conn->commit();
                        echo json_encode(['success' => true, 'message' => 'Product restored successfully.']);
                    } else {
                        throw new Exception("Failed to remove product from archive.");
                    }
                } else {
                    throw new Exception("Failed to restore product.");
                }
            } catch (Exception $e) {
                $conn->rollback();
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }

            $stmt_restore->close();
            $stmt_delete->close();
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid password.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Admin user not found.']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Error preparing query.']);
}

$conn->close();
?>
