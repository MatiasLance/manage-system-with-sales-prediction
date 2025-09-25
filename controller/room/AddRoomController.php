<?php
session_start();

require_once __DIR__ . '/../../config/db_connection.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $addedRoom = htmlspecialchars(trim($_POST['room']));
    $status = htmlspecialchars(trim($_POST["status"] ?? "available"));

    $errors = [];

    if (!in_array($status, ["available", "occupied"])) {
        $errors[] = "Invalid status.";
    }
    if(empty($addedRoom)){
        $errors[] = "Room is required.";
    }

    $checkSelectedRoom = "SELECT COUNT(*) FROM room WHERE room_number = ?";
    $checkStmt = $conn->prepare($checkSelectedRoom);
    $checkStmt->bind_param("s", $addedRoom);
    $checkStmt->execute();
    $checkStmt->bind_result($existingSelectedRoom);
    $checkStmt->fetch();
    $checkStmt->close();

    if ($existingSelectedRoom > 0) {
        echo json_encode(["error" => true, "message" => "Room ". $addedRoom ." is already exist."]);
        exit;
    }

    $sql = "INSERT INTO room (room_number, status) 
            VALUES (?, ?)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo json_encode(["error" => true, "message" => "Database error: " . $conn->error]);
        exit;
    }

    $stmt->bind_param(
        "ss",
        $addedRoom,
        $status
    );

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Room added successfully!"]);
    } else {
        echo json_encode(["error" => true, "message" => "Failed to add room."]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["error" => true, "message" => "Invalid request method."]);
}
