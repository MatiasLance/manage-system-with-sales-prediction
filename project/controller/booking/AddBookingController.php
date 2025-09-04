<?php
session_start();

require_once __DIR__ . '/../../config/db_connection.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $selectedRoomID = filter_input(INPUT_POST, 'selected_room_id', FILTER_VALIDATE_INT);
    $first_name = htmlspecialchars(trim($_POST["first_name"] ?? ""));
    $middle_name = htmlspecialchars(trim($_POST["middle_name"] ?? ""));
    $last_name = htmlspecialchars(trim($_POST["last_name"] ?? ""));
    $email = filter_var(trim($_POST["email"] ?? ""), FILTER_VALIDATE_EMAIL);
    $phone_number = htmlspecialchars(trim($_POST["phone_number"] ?? ""));
    $status = htmlspecialchars(trim($_POST["status"] ?? "pending"));
    $guestCount = (int) $_POST['guest_count'];
    $booking_schedule = htmlspecialchars(trim($_POST["booking_schedule"] ?? ""));
    $check_in = htmlspecialchars(trim($_POST["check_in"] ?? ""));
    $check_out = htmlspecialchars(trim($_POST["check_out"] ?? ""));

    $errors = [];

    if (empty($first_name)) $errors[] = "First name is required.";
    if (empty($last_name)) $errors[] = "Last name is required.";
    if (!$email) $errors[] = "A valid email is required.";
    if (!empty($phone_number) && !preg_match('/^09\d{9}$/', $phone_number)) {
        $errors[] = "Phone number must start with 09 and contain a total of 11 digits.";
    }    
    if (!in_array($status, ["pending", "confirmed", "cancelled"])) {
        $errors[] = "Invalid status.";
    }
    if(is_nan($guestCount)){
        $errors[] = "Please enter a valid number for the guest count.";
    }
    if(!$selectedRoomID || $selectedRoomID <= 0){
        $errors[] = "Please enter a valid room id.";
    }
    if (!empty($booking_schedule) && !strtotime($booking_schedule)) {
        $errors[] = "Invalid booking schedule format.";
    }

    if (!empty($errors)) {
        echo json_encode(["error" => true, "messages" => $errors]);
        exit;
    }

    $checkBookingSchedule = "SELECT COUNT(*) FROM booking WHERE booking_schedule = ? AND status IN ('pending', 'confirmed')";
    $checkStmt = $conn->prepare($checkBookingSchedule);
    $checkStmt->bind_param("s", $booking_schedule);
    $checkStmt->execute();
    $checkStmt->bind_result($existingBookings);
    $checkStmt->fetch();
    $checkStmt->close();

    if ($existingBookings > 0) {
        echo json_encode(["error" => true, "message" => "A booking already exists for this date. Please choose another day."]);
        exit;
    }

    $checkSelectedRoom = "SELECT COUNT(*) FROM booking WHERE room_id = ? AND status IN ('occupied')";
    $checkStmt = $conn->prepare($checkSelectedRoom);
    $checkStmt->bind_param("i", $selectedRoomID);
    $checkStmt->execute();
    $checkStmt->bind_result($existingSelectedRoom);
    $checkStmt->fetch();
    $checkStmt->close();

    if ($existingSelectedRoom > 0) {
        echo json_encode(["error" => true, "message" => "Room ". $selectedRoom ." is not available."]);
        exit;
    }

    $sql = "INSERT INTO booking (room_id, first_name, middle_name, last_name, email, phone_number, status, guest_count, booking_schedule, check_in, check_out) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo json_encode(["error" => true, "message" => "Database error: " . $conn->error]);
        exit;
    }

    $stmt->bind_param(
        "issssssssss",
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
        $check_out
    );

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Booking added successfully!"]);
    } else {
        echo json_encode(["error" => true, "message" => "Failed to add booking."]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["error" => true, "message" => "Invalid request method."]);
}
