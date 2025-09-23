<?php

session_start();
require_once __DIR__ . '/../../config/db_connection.php';
require_once __DIR__ . '/../../helper/helper.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["error" => true, "message" => "Invalid request method."]);
    exit;
}

$id               = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$selectedRoomID   = filter_input(INPUT_POST, 'selected_room_id', FILTER_VALIDATE_INT);
$first_name       = htmlspecialchars(trim($_POST['first_name'] ?? ''), ENT_QUOTES, 'UTF-8');
$middle_name      = htmlspecialchars(trim($_POST['middle_name'] ?? ''), ENT_QUOTES, 'UTF-8') ?: null;
$last_name        = htmlspecialchars(trim($_POST['last_name'] ?? ''), ENT_QUOTES, 'UTF-8');
$email            = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
$phone_number     = htmlspecialchars(trim($_POST['phone_number'] ?? ''), ENT_QUOTES, 'UTF-8');
$status           = htmlspecialchars(trim($_POST['status'] ?? 'pending'), ENT_QUOTES, 'UTF-8');
$guestCount       = filter_input(INPUT_POST, 'guest_count', FILTER_VALIDATE_INT);
$booking_range    = trim($_POST['booking_schedule'] ?? '');
$check_in         = trim($_POST['check_in'] ?? '');
$check_out        = trim($_POST['check_out'] ?? '');

$errors = [];

if (!$id || $id <= 0) {
    $errors[] = "Invalid Booking ID.";
}
if (!$selectedRoomID || $selectedRoomID <= 0) {
    $errors[] = "Please select a valid room.";
}
if (empty($first_name)) {
    $errors[] = "First name is required.";
}
if (empty($last_name)) {
    $errors[] = "Last name is required.";
}
if (!$email) {
    $errors[] = "A valid email is required.";
}
if (empty($phone_number)) {
    $errors[] = "Phone number is required.";
} else if (!preg_match('/^(9|63)\d{9,10}$/', $phone_number)) {
    $errors[] = "Phone number must start with '9' or '63' and be 10–11 digits long.";
}
if ($guestCount === false || $guestCount < 1) {
    $errors[] = "Guest count must be a positive integer.";
}
if (!in_array(strtolower($status), ['pending', 'confirmed', 'cancelled', 'done'])) {
    $errors[] = "Status must be 'pending', 'confirmed', 'cancelled', or 'done'.";
}

$dates = null;
if (!empty($booking_range)) {
    try {
        $dates = parseBookingDateRange($booking_range);
    } catch (InvalidArgumentException $e) {
        $errors[] = $e->getMessage();
    }
}

if (!empty($errors)) {
    echo json_encode(["errors" => true, "messages" => $errors]);
    exit;
}

if (is_null($dates)) {
    $start_date = trim($_POST['start_date'] ?? '');
    $end_date = trim($_POST['end_date'] ?? '');
} else {
    ['start_db' => $start_date, 'end_db' => $end_date] = $dates;
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

    if ($selectedRoomID !== $old_room_id) {
        echo json_encode([
            "error" => true,
            "message" => "Selected room cannot be modified after booking creation."
        ]);
        exit;
    }

    $checkRoom = $conn->prepare("SELECT status, room_number FROM room WHERE id = ?");
    $checkRoom->bind_param("i", $selectedRoomID);
    $checkRoom->execute();
    $checkRoom->bind_result($room_status, $room_number);

    if (!$checkRoom->fetch()) {
        $checkRoom->close();
        echo json_encode([
            "error" => true,
            "message" => "Room not found."
        ]);
        exit;
    }
    $checkRoom->close();

    $overlapSql = "SELECT id FROM booking 
                   WHERE id != ? 
                     AND room_id = ? 
                     AND status IN ('pending', 'confirmed')
                     AND ? < end_date 
                     AND ? > start_date";

    $overlapStmt = $conn->prepare($overlapSql);
    $overlapStmt->bind_param("iiss", $id, $selectedRoomID, $start_date, $end_date);
    $overlapStmt->execute();
    $overlapStmt->store_result();

    if ($overlapStmt->num_rows > 0) {
        $overlapStmt->close();
        echo json_encode([
            "error" => true,
            "message" => "This room is already booked for the selected dates. Please choose another date."
        ]);
        exit;
    }
    $overlapStmt->close();

    $updateSql = "UPDATE booking 
                  SET 
                      first_name = ?, 
                      middle_name = ?, 
                      last_name = ?, 
                      email = ?, 
                      phone_number = ?, 
                      status = ?,
                      guest_count = ?,
                      start_date = ?,
                      end_date = ?,
                      check_in = ?, 
                      check_out = ?
                  WHERE id = ?";

    $stmt = $conn->prepare($updateSql);
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param(
        "ssssssissssi",
        $first_name,
        $middle_name,
        $last_name,
        $email,
        $phone_number,
        $status,
        $guestCount,
        $start_date,
        $end_date,
        $check_in,
        $check_out,
        $id
    );

    if (!$stmt->execute()) {
        throw new Exception("Update booking failed: " . $stmt->error);
    }
    $stmt->close();

    if (strtolower($status) === 'confirmed') {
        $updateRoom = $conn->prepare("UPDATE room SET status = 'occupied' WHERE id = ?");
        $updateRoom->bind_param("i", $selectedRoomID);
        if (!$updateRoom->execute()) {
            throw new Exception("Failed to update room status: " . $updateRoom->error);
        }
        $updateRoom->close();
    } elseif (in_array(strtolower($status), ['done', 'cancelled'])) {
        $updateRoom = $conn->prepare("UPDATE room SET status = 'available' WHERE id = ?");
        $updateRoom->bind_param("i", $selectedRoomID);
        if (!$updateRoom->execute()) {
            throw new Exception("Failed to update room status: " . $updateRoom->error);
        }
        $updateRoom->close();
    }

    $conn->commit();
    $conn->autocommit(TRUE);

    echo json_encode([
        "success" => true,
        "message" => "Booking updated successfully.",
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