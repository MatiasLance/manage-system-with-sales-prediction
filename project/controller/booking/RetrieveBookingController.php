<?php
session_start();
header("Content-Type: application/json");

require_once __DIR__ . '/../../config/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        echo json_encode(["error" => "Invalid ID"]);
        exit;
    }

    $id = intval($_GET['id']); // Ensure ID is an integer for security

    // Prepare the SQL query
    $stmt = $conn->prepare("
        SELECT first_name, middle_name, last_name, email, phone_number, status, booking_schedule
        FROM booking 
        WHERE id = ?
    ");
    $stmt->bind_param("i", $id);

    // Execute query
    if ($stmt->execute()) {
        // Bind result variables
        $stmt->bind_result($first_name, $middle_name, $last_name, $email, $phone_number, $status, $booking_schedule);

        // Fetch the result
        if ($stmt->fetch()) {
            echo json_encode([
                "first_name"   => $first_name,
                "middle_name"  => $middle_name,
                "last_name"    => $last_name,
                "email"        => $email,
                "phone_number" => $phone_number,
                "status"       => $status,
                "booking_schedule" => $booking_schedule
            ]);
        } else {
            echo json_encode(["error" => true, "message" => "No data found"]);
        }
    } else {
        echo json_encode(["error" => true, "message" => "Query execution failed"]);
    }

    // Close connections
    $stmt->close();
    $conn->close();
}
?>
