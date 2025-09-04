<?php
session_start();
require_once __DIR__ . '/../../config/db_connection.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $roomNumber = htmlspecialchars(trim($_POST["room"] ?? ""));
    $status = htmlspecialchars(trim($_POST["status"] ?? ""));

    $errors = [];

    if (!$id || $id <= 0) {
        $errors[] = "Invalid Room ID.";
    }
    if (!in_array(strtolower($status), ['available', 'occupied'])) {
        $errors[] = "Invalid status value.";
    }

    if (!empty($errors)) {
        echo json_encode(["error" => true, "message" => $errors]);
        exit;
    }

    $check_stmt = $conn->prepare("SELECT COUNT(*) FROM room WHERE id = ?");
    $check_stmt->bind_param("i", $id);
    $check_stmt->execute();
    $check_stmt->bind_result($roomCount);
    $check_stmt->fetch();
    $check_stmt->close();

    if ($roomCount === 0) {
        echo json_encode(["error" => true, "message" => "Room not found."]);
        exit;
    }

    $sql = "UPDATE room 
            SET room_number = ?, status = ?
            WHERE id = ?";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo json_encode(["error" => true, "message" => "Database error: " . $conn->error]);
        exit;
    }

    $stmt->bind_param(
        "ssi",
        $roomNumber,
        $status,
        $id
    );

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Room details updated successfully!"]);
    } else {
        echo json_encode(["error" => true, "message" => "Error updating booking details: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["error" => true, "message" => "Invalid request method."]);
    exit;
}
