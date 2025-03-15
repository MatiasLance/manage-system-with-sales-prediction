<?php
session_start();
require_once __DIR__ . '/../../config/db_connection.php';

header('Content-Type: application/json');

// Check if password and employee ID are provided
if (!isset($_POST['password'], $_POST['id'])) {
    echo json_encode(['success' => false, 'message' => 'Password and employee ID are required.']);
    exit;
}

// Sanitize and validate input
$password = trim($_POST['password']);
$employee_id = filter_var($_POST['id'], FILTER_VALIDATE_INT);

if (!$employee_id || $employee_id <= 0) {
    echo json_encode(['error' => true, 'message' => 'Invalid employee ID.']);
    exit;
}

// Get the admin's hashed password from the database
$sql = "SELECT password FROM users WHERE user_type = 'admin' LIMIT 1";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode(['error' => true, 'message' => 'Error preparing query.']);
    exit;
}

$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($password_db);
    $stmt->fetch();

    // Verify password
    if (password_verify($password, $password_db)) {
        // Password is correct, check if employee exists
        $checkSql = "SELECT id FROM employees WHERE id = ?";
        $checkStmt = $conn->prepare($checkSql);

        if ($checkStmt) {
            $checkStmt->bind_param("i", $employee_id);
            $checkStmt->execute();
            $checkStmt->store_result();

            if ($checkStmt->num_rows === 0) {
                echo json_encode(['error' => true, 'message' => 'Employee not found.']);
                $checkStmt->close();
                $stmt->close();
                $conn->close();
                exit;
            }
            $checkStmt->close();
        }

        // Proceed with employee deletion
        $deleteSql = "DELETE FROM employees WHERE id = ?";
        $deleteStmt = $conn->prepare($deleteSql);

        if ($deleteStmt) {
            $deleteStmt->bind_param("i", $employee_id);
            if ($deleteStmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Employee deleted successfully.']);
            } else {
                echo json_encode(['error' => true, 'message' => 'Failed to delete employee.']);
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
$conn->close();
?>
