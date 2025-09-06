<?php

session_start();

require_once __DIR__ . '/../../config/db_connection.php';
require_once __DIR__ . '/../../helper/helper.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["error" => true, "message" => "Invalid request method."]);
    exit;
}

$selectedRoomID = filter_input(INPUT_POST, 'selected_room_id', FILTER_VALIDATE_INT);
$first_name     = htmlspecialchars(trim($_POST['first_name'] ?? ''), ENT_QUOTES, 'UTF-8');
$middle_name    = htmlspecialchars(trim($_POST['middle_name'] ?? ''), ENT_QUOTES, 'UTF-8') ?: null;
$last_name      = htmlspecialchars(trim($_POST['last_name'] ?? ''), ENT_QUOTES, 'UTF-8');
$email          = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
$phone_number   = htmlspecialchars(trim($_POST['phone_number'] ?? ''), ENT_QUOTES, 'UTF-8');
$status         = htmlspecialchars(trim($_POST['status'] ?? 'pending'), ENT_QUOTES, 'UTF-8');
$guestCount     = filter_input(INPUT_POST, 'guest_count', FILTER_VALIDATE_INT);
$booking_range  = htmlspecialchars(trim($_POST['booking_schedule'] ?? ''));
$check_in       = htmlspecialchars(trim($_POST['check_in'] ?? ''));
$check_out      = htmlspecialchars(trim($_POST['check_out'] ?? ''));

$errors = [];

if (empty($first_name)) $errors[] = "First name is required.";
if (empty($last_name)) $errors[] = "Last name is required.";
if (!$email) $errors[] = "A valid email is required.";
if (empty($phone_number)) {
    $errors[] = "Phone number is required.";
} else if (!preg_match('/^09\d{9}$/', $phone_number)) {
    $errors[] = "Phone number must start with 09 and be 11 digits long.";
}
if (!in_array($status, ['pending', 'confirmed', 'cancelled', 'done'])) {
    $errors[] = "Invalid status. Allowed: pending, confirmed, cancelled, done.";
}
if ($guestCount === false || $guestCount < 1) {
    $errors[] = "Guest count must be a positive integer.";
}
if (!$selectedRoomID || $selectedRoomID <= 0) {
    $errors[] = "Please select a valid room.";
}

$dates = null;
if (!empty($booking_range)) {
    try {
        $dates = parseBookingDateRange($booking_range);
    } catch (InvalidArgumentException $e) {
        $errors[] = $e->getMessage();
    }
} else {
    $errors[] = "Booking schedule is required.";
}

if (!empty($errors)) {
    echo json_encode(["error" => true, "messages" => $errors]);
    exit;
}

['start_db' => $start_date, 'end_db' => $end_date] = $dates;

$sql = "SELECT id FROM booking 
        WHERE room_id = ? 
          AND status IN ('confirmed') 
          AND ? < end_date 
          AND ? > start_date";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iss", $selectedRoomID, $start_date, $end_date);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->close();
    echo json_encode([
        "error" => true,
        "message" => "This room is already booked for the selected dates. Please choose another date."
    ]);
    exit;
}
$stmt->close();

$sql = "INSERT INTO booking 
        (room_id, first_name, middle_name, last_name, email, phone_number, 
         status, guest_count, start_date, end_date, check_in, check_out) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(["error" => true, "message" => "Database prepare failed: " . $conn->error]);
    $conn->close();
    exit;
}

$stmt->bind_param(
    "issssssissss", 
    $selectedRoomID,
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
    $check_out
);

if ($stmt->execute()) {
    $bookingId = $stmt->insert_id;
    echo json_encode([
        "success" => true,
        "message" => "Booking added successfully!",
    ]);
} else {
    error_log("Booking insert failed: " . $stmt->error);
    echo json_encode(["error" => true, "message" => "Failed to add booking. Please try again."]);
}

$stmt->close();
$conn->close();
exit;