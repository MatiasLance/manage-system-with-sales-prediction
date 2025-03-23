<?php
session_start();
require_once __DIR__ . '/../../config/db_connection.php';

header('Content-Type: application/json');

// Check if password and booking ID are provided
if (!isset($_POST['password'], $_POST['id'])) {
    echo json_encode(['success' => false, 'message' => 'Password and booking ID are required.']);
    exit;
}

// Sanitize and validate input
$password = trim($_POST['password']);
$booking_id = filter_var($_POST['id'], FILTER_VALIDATE_INT);

if (!$booking_id || $booking_id <= 0) {
    echo json_encode(['error' => true, 'message' => 'Invalid booking ID.']);
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
        // Password is correct, check if booking exists
        $checkSql = "SELECT id FROM booking WHERE id = ?";
        $checkStmt = $conn->prepare($checkSql);

        if ($checkStmt) {
            $checkStmt->bind_param("i", $booking_id);
            $checkStmt->execute();
            $checkStmt->store_result();

            if ($checkStmt->num_rows === 0) {
                echo json_encode(['error' => true, 'message' => 'Booking not found.']);
                $checkStmt->close();
                $stmt->close();
                $conn->close();
                exit;
            }
            $checkStmt->close();
        }

        // Proceed with booking deletion
        $deleteSql = "DELETE FROM booking WHERE id = ?";
        $deleteStmt = $conn->prepare($deleteSql);

        if ($deleteStmt) {
            $deleteStmt->bind_param("i", $booking_id);
            if ($deleteStmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Booking deleted successfully.']);
            } else {
                echo json_encode(['error' => true, 'message' => 'Failed to delete booking.']);
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
