<?php

session_start();

require_once __DIR__ . '/../../config/db_connection.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = htmlspecialchars(trim($_POST["title"] ?? ""));
    $content = htmlspecialchars(trim($_POST["content"] ?? ""));

    $errors = [];

    if (empty($title)) $errors[] = "Title is required.";
    if (empty($content)) $errors[] = "Content is required.";

    if (!empty($errors)) {
        echo json_encode(["error" => true, "messages" => $errors]);
        exit;
    }
    $sql = "INSERT INTO news (title, content) 
            VALUES (?, ?)";
    
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        echo json_encode(["error" => true, "message" => "Database error: " . $conn->error]);
        exit;
    }

    $stmt->bind_param("ss", $title, $content);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "News added successfully."]);
    } else {
        echo json_encode(["error" => true, "message" => "Failed to add news: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
    exit;
} else {
    echo json_encode(["error" => true, "message" => "Invalid request method."]);
}