<?php

session_start();

require_once __DIR__ . '/../../config/db_connection.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $newsId = intval($_POST["id"] ?? 0);
    $title = htmlspecialchars(trim($_POST["title"] ?? ""));
    $content = htmlspecialchars(trim($_POST["content"] ?? ""));

    $errors = [];

    if ($newsId <= 0) $errors[] = "Invalid news ID.";
    if (empty($title)) $errors[] = "Title is required.";
    if (empty($content)) $errors[] = "Content is required.";

    if (!empty($errors)) {
        echo json_encode(["error" => true, "messages" => $errors]);
        exit;
    }

    $sql = "UPDATE news SET title = ?, content = ? WHERE id = ?";
    
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        echo json_encode(["error" => true, "message" => "Database error: " . $conn->error]);
        exit;
    }

    $stmt->bind_param("ssi", $title, $content, $newsId);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(["success" => true, "message" => "News updated successfully."]);
        } else {
            echo json_encode(["error" => true, "message" => "No news found with the given ID."]);
        }
    } else {
        echo json_encode(["error" => true, "message" => "Failed to update news: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
    exit;
} else {
    echo json_encode(["error" => true, "message" => "Invalid request method."]);
}