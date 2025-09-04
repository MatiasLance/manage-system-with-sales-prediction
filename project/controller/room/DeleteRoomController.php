<?php
session_start();
require_once __DIR__ . '/../../config/db_connection.php';

header('Content-Type: application/json');

if (!isset($_POST['password'], $_POST['id'])) {
    echo json_encode(['success' => false, 'message' => 'Password and booking ID are required.']);
    exit;
}

$password = trim($_POST['password']);
$room_id = filter_var($_POST['id'], FILTER_VALIDATE_INT);

if (!$room_id || $room_id <= 0) {
    echo json_encode(['error' => true, 'message' => 'Invalid Room ID.']);
    exit;
}

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

    if (password_verify($password, $password_db)) {
        $checkSql = "SELECT id FROM room WHERE id = ?";
        $checkStmt = $conn->prepare($checkSql);

        if ($checkStmt) {
            $checkStmt->bind_param("i", $room_id);
            $checkStmt->execute();
            $checkStmt->store_result();

            if ($checkStmt->num_rows === 0) {
                echo json_encode(['error' => true, 'message' => 'Room not found.']);
                $checkStmt->close();
                $stmt->close();
                $conn->close();
                exit;
            }
            $checkStmt->close();
        }

        $deleteSql = "DELETE FROM room WHERE id = ?";
        $deleteStmt = $conn->prepare($deleteSql);

        if ($deleteStmt) {
            $deleteStmt->bind_param("i", $room_id);
            if ($deleteStmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Room deleted successfully.']);
            } else {
                echo json_encode(['error' => true, 'message' => 'Failed to delete room.']);
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
