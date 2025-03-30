<?php
session_start();
require_once __DIR__ . '/../../config/db_connection.php';

header('Content-Type: application/json');

// Check if request is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and validate input data
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $first_name = htmlspecialchars(trim($_POST["first_name"] ?? ""));
    $middle_name = htmlspecialchars(trim($_POST["middle_name"] ?? ""));
    $last_name = htmlspecialchars(trim($_POST["last_name"] ?? ""));
    $email = filter_var(trim($_POST["email"] ?? ""), FILTER_VALIDATE_EMAIL);
    $phone_number = htmlspecialchars(trim($_POST["phone_number"] ?? ""));
    $status = htmlspecialchars(trim($_POST["status"] ?? ""));
    $booking_schedule = htmlspecialchars(trim($_POST["booking_schedule"] ?? ""));
    $check_in = htmlspecialchars(trim($_POST["check_in"] ?? ""));
    $check_out = htmlspecialchars(trim($_POST["check_out"] ?? ""));

    // Array to store errors
    $errors = [];

    // Validation checks
    if (!$id || $id <= 0) {
        $errors[] = "Invalid Booking ID.";
    }
    if (empty($first_name)) {
        $errors[] = "First name is required.";
    }
    if (empty($last_name)) {
        $errors[] = "Last name is required.";
    }
    if (!$email) {
        $errors[] = "Invalid email format.";
    }
    if (!preg_match("/^(09|63)\d{9}$/", $phone_number)) {
        $errors[] = "Invalid phone number format. Must start with '09' or '63' and be 11 digits long.";
    }
    if (!in_array(strtolower($status), ['pending', 'confirmed', 'cancelled'])) {
        $errors[] = "Invalid status value.";
    }
    if (!empty($booking_schedule) && !strtotime($booking_schedule)) {
        $errors[] = "Invalid booking schedule format.";
    }

    // If there are errors, stop execution
    if (!empty($errors)) {
        echo json_encode(["error" => true, "message" => $errors]);
        exit;
    }

    // Check if the booking exists before updating
    $check_stmt = $conn->prepare("SELECT COUNT(*) FROM booking WHERE id = ?");
    $check_stmt->bind_param("i", $id);
    $check_stmt->execute();
    $check_stmt->bind_result($bookingCount);
    $check_stmt->fetch();
    $check_stmt->close();

    if ($bookingCount === 0) {
        echo json_encode(["error" => true, "message" => "Booking not found."]);
        exit;
    }

    // Update query with prepared statement
    $sql = "UPDATE booking 
            SET first_name = ?, middle_name = ?, last_name = ?, email = ?, 
                phone_number = ?, status = ?, booking_schedule = ?, check_in = ?, check_out = ?
            WHERE id = ?";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo json_encode(["error" => true, "message" => "Database error: " . $conn->error]);
        exit;
    }

    $stmt->bind_param(
        "sssssssi",
        $first_name,
        $middle_name,
        $last_name,
        $email,
        $phone_number,
        $status,
        $booking_schedule,
        $check_in,
        $check_out,
        $id
    );

    // Execute the statement
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Booking details updated successfully!"]);
    } else {
        echo json_encode(["error" => true, "message" => "Error updating booking details: " . $stmt->error]);
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["error" => true, "message" => "Invalid request method."]);
    exit;
}
?>
