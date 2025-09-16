<?php

session_start();
require_once __DIR__ . '/../../config/db_connection.php';
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["error" => true, "message" => "Invalid request method."]);
    exit;
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$status = htmlspecialchars(trim($_POST['booking_status'] ?? 'pending'), ENT_QUOTES, 'UTF-8');

$errors = [];

if (!$id || $id <= 0) {
    $errors[] = "Invalid Booking ID.";
}

if (!in_array(strtolower($status), ['pending', 'confirmed', 'cancelled', 'done'])) {
    $errors[] = "Status must be 'pending', 'confirmed', 'cancelled', or 'done'.";
}


$conn->autocommit(FALSE);

try {
    $checkBooking = $conn->prepare("SELECT room_id FROM booking WHERE id = ?");
    $checkBooking->bind_param("i", $id);
    $checkBooking->execute();
    $checkBooking->bind_result($old_room_id);
    
    if (!$checkBooking->fetch()) {
        $checkBooking->close();
        echo json_encode([
            "error" => true,
            "message" => "Booking not found."
        ]);
        exit;
    }
    $checkBooking->close();
 
    $updateSql = "UPDATE booking SET status = ? WHERE id = ?";

    $stmt = $conn->prepare($updateSql);
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param(
        "si",
        $status,
        $id
    );

    if (!$stmt->execute()) {
        throw new Exception("Update booking status failed: " . $stmt->error);
    }
    $stmt->close();

    if (strtolower($status) === 'confirmed') {
        $updateRoom = $conn->prepare("UPDATE room SET status = 'occupied' WHERE id = ?");
        $updateRoom->bind_param("i", $old_room_id);
        if (!$updateRoom->execute()) {
            throw new Exception("Failed to update room status: " . $updateRoom->error);
        }
        $updateRoom->close();
    } elseif (in_array(strtolower($status), ['done', 'cancelled'])) {
        $updateRoom = $conn->prepare("UPDATE room SET status = 'available' WHERE id = ?");
        $updateRoom->bind_param("i", $old_room_id);
        if (!$updateRoom->execute()) {
            throw new Exception("Failed to update room status: " . $updateRoom->error);
        }
        $updateRoom->close();
    }

    $conn->commit();
    $conn->autocommit(TRUE);

    echo json_encode([
        "success" => true,
        "message" => "Booking Status Updated Successfully.",
    ]);

} catch (Exception $e) {
    $conn->rollback();
    $conn->autocommit(TRUE);

    echo json_encode([
        "error" => true,
        "message" => $e->getMessage()
    ]);
}

$conn->close();