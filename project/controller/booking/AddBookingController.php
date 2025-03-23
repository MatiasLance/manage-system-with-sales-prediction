<?php
session_start();

require_once __DIR__ . '/../../config/db_connection.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and trim input
    $first_name = htmlspecialchars(trim($_POST["first_name"] ?? ""));
    $middle_name = htmlspecialchars(trim($_POST["middle_name"] ?? ""));
    $last_name = htmlspecialchars(trim($_POST["last_name"] ?? ""));
    $email = filter_var(trim($_POST["email"] ?? ""), FILTER_VALIDATE_EMAIL);
    $phone_number = htmlspecialchars(trim($_POST["phone_number"] ?? ""));
    $status = htmlspecialchars(trim($_POST["status"] ?? "pending"));
    $booking_schedule = htmlspecialchars(trim($_POST["booking_schedule"] ?? ""));

    // Validation rules
    $errors = [];

    if (empty($first_name)) $errors[] = "First name is required.";
    if (empty($last_name)) $errors[] = "Last name is required.";
    if (!$email) $errors[] = "A valid email is required.";
    if (!empty($phone_number) && !preg_match('/^\+639\d{9}$/', $phone_number)) {
        $errors[] = "Phone number must start with +63, followed by 9, and contain a total of 13 characters.";
    }
    if (!in_array($status, ["pending", "confirmed", "cancelled"])) {
        $errors[] = "Invalid status.";
    }
    if (!empty($booking_schedule) && !strtotime($booking_schedule)) {
        $errors[] = "Invalid booking schedule format.";
    }

    // Return errors if any
    if (!empty($errors)) {
        echo json_encode(["error" => true, "messages" => $errors]);
        exit;
    }

    // Check if there is an existing confirmed or pending booking for the same day
    $checkSql = "SELECT COUNT(*) FROM booking WHERE booking_schedule = ? AND status IN ('pending', 'confirmed')";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("s", $booking_schedule);
    $checkStmt->execute();
    $checkStmt->bind_result($existingBookings);
    $checkStmt->fetch();
    $checkStmt->close();

    if ($existingBookings > 0) {
        echo json_encode(["error" => true, "message" => "A booking already exists for this date. Please choose another day."]);
        exit;
    }

    // Insert data using prepared statements
    $sql = "INSERT INTO booking (first_name, middle_name, last_name, email, phone_number, status, booking_schedule) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo json_encode(["error" => true, "message" => "Database error: " . $conn->error]);
        exit;
    }

    $stmt->bind_param(
        "sssssss", 
        $first_name, 
        $middle_name, 
        $last_name, 
        $email, 
        $phone_number, 
        $status,
        $booking_schedule
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
?>
