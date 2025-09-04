<?php
session_start();
require_once __DIR__ . '/../../config/db_connection.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["error" => true, "message" => "Invalid request method."]);
    exit;
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$selectedRoomID = filter_input(INPUT_POST, 'selected_room_id', FILTER_VALIDATE_INT);
$first_name = htmlspecialchars(trim($_POST['first_name'] ?? ''), ENT_QUOTES, 'UTF-8');
$middle_name = htmlspecialchars(trim($_POST['middle_name'] ?? ''), ENT_QUOTES, 'UTF-8');
$last_name = htmlspecialchars(trim($_POST['last_name'] ?? ''), ENT_QUOTES, 'UTF-8');
$email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
$phone_number = htmlspecialchars(trim($_POST['phone_number'] ?? ''), ENT_QUOTES, 'UTF-8');
$guestCount = (int) $_POST['guest_count'];
$status = htmlspecialchars(trim($_POST['status'] ?? ''), ENT_QUOTES, 'UTF-8');
$date = trim($_POST['booking_schedule'] ?? '');
$check_in = trim($_POST['check_in'] ?? '') ?: null;
$check_out = trim($_POST['check_out'] ?? '') ?: null;

$parseDate = strtotime($date);
$booking_schedule = date('Y-m-d H:i:s', $parseDate);
var_dump($booking_schedule);


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

if (!preg_match("/^(09|63)\d{9,10}$/", $phone_number)) {
    $errors[] = "Phone number must start with '09' or '63' and be 10–11 digits long.";
}

if(is_nan($guestCount)){
    $errors[] = "Please enter a valid number for the guest count.";
}

if (!in_array(strtolower($status), ['pending', 'confirmed', 'cancelled'])) {
    $errors[] = "Status must be 'pending', 'confirmed', or 'cancelled'.";
}

if (!empty($booking_schedule) && !strtotime($booking_schedule)) {
    $errors[] = "Invalid booking schedule date/time.";
}

if (!empty($check_in) && !date_create_from_format('H:i', $check_in)) {
    $errors[] = "Invalid check-in time format. Use HH:MM.";
}

if (!empty($check_out) && !date_create_from_format('H:i', $check_out)) {
    $errors[] = "Invalid check-out time format. Use HH:MM.";
}

if (!empty($errors)) {
    http_response_code(400);
    echo json_encode(["error" => true, "message" => $errors]);
    exit;
}

$checkBooking = $conn->prepare("SELECT room_id FROM booking WHERE id = ?");
$checkBooking->bind_param("i", $id);
$checkBooking->execute();
$checkBooking->bind_result($old_room_id);
if (!$checkBooking->fetch()) {
    $checkBooking->close();
    http_response_code(404);
    echo json_encode(["error" => true, "message" => "Booking not found."]);
    exit;
}
$checkBooking->close();

$checkRoom = $conn->prepare("
    SELECT status, room_number 
    FROM room 
    WHERE id = ?
");
$checkRoom->bind_param("i", $selectedRoomID);
$checkRoom->execute();
$checkRoom->bind_result($room_status, $room_number);
if (!$checkRoom->fetch()) {
    $checkRoom->close();
    http_response_code(404);
    echo json_encode(["error" => true, "message" => "Room not found."]);
    exit;
}
$checkRoom->close();

if ($room_status === 'occupied' && $selectedRoomID != $old_room_id) {
    http_response_code(400);
    echo json_encode([
        "error" => true,
        "message" => "Room #$room_number is currently occupied and cannot be assigned."
    ]);
    exit;
}

$conn->autocommit(FALSE);

try {
    $sql = "UPDATE booking 
            SET 
                room_id = ?, 
                first_name = ?, 
                middle_name = ?, 
                last_name = ?, 
                email = ?, 
                phone_number = ?, 
                status = ?,
                guest_count = ?
                booking_schedule = ?, 
                check_in = ?, 
                check_out = ?
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param(
        "issssssisssi",
        $selectedRoomID,
        $first_name,
        $middle_name,
        $last_name,
        $email,
        $phone_number,
        $status,
        $guestCount,
        $booking_schedule,
        $check_in,
        $check_out,
        $id
    );

    if (!$stmt->execute()) {
        throw new Exception("Update booking failed: " . $stmt->error);
    }

    if (strtolower($status) === 'confirmed') {
        $updateRoom = $conn->prepare("UPDATE room SET status = 'occupied' WHERE id = ?");
        $updateRoom->bind_param("i", $selectedRoomID);
        if (!$updateRoom->execute()) {
            throw new Exception("Failed to update room status: " . $updateRoom->error);
        }
        $updateRoom->close();
    }

    if ($old_room_id && $old_room_id != $selectedRoomID) {
        $releaseOldRoom = $conn->prepare("UPDATE room SET status = 'available' WHERE id = ? AND status = 'occupied'");
        $releaseOldRoom->bind_param("i", $old_room_id);
        $releaseOldRoom->execute();
        $releaseOldRoom->close();
    }

    $conn->commit();
    $conn->autocommit(TRUE);

    echo json_encode([
        "success" => true,
        "message" => "Booking and room assignment updated successfully."
    ]);

} catch (Exception $e) {
    $conn->rollback();
    $conn->autocommit(TRUE);


    http_response_code(500);
    echo json_encode([
        "error" => true,
        "message" => "An error occurred while updating the booking. Please try again.",
    ]);
}

$conn->close();