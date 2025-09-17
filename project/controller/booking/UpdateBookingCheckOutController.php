<?php

session_start();
require_once __DIR__ . '/../../config/db_connection.php';
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["error" => true, "message" => "Invalid request method."]);
    exit;
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$check_out = trim($_POST['check_out'] ?? '');

$errors = [];

if (!$id || $id <= 0) {
    $errors[] = "Invalid Booking ID.";
}


$conn->autocommit(FALSE);

try {
    $checkBooking = $conn->prepare("SELECT room_id, status FROM booking WHERE id = ?");
    $checkBooking->bind_param("i", $id);
    $checkBooking->execute();
    $checkBooking->bind_result($old_room_id, $old_booking_status);
    
    if (!$checkBooking->fetch()) {
        $checkBooking->close();
        echo json_encode([
            "error" => true,
            "message" => "Booking not found."
        ]);
        exit;
    }
    $checkBooking->close();

    $updateSql = "UPDATE booking SET check_out = ?, status = ? WHERE id = ?";

    $stmt = $conn->prepare($updateSql);
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param(
        "ssi",
        $check_out,
        $old_booking_status,
        $id
    );

    if (!$stmt->execute()) {
        throw new Exception("Update check out failed: " . $stmt->error);
    }
    $stmt->close();

    $conn->commit();
    $conn->autocommit(TRUE);

    echo json_encode([
        "success" => true,
        "message" => "Check Out Updated Successfully.",
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