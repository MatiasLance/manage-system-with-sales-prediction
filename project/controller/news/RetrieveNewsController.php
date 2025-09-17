<?php
session_start();
header("Content-Type: application/json");

require_once __DIR__ . '/../../config/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        echo json_encode(["error" => "Invalid ID"]);
        exit;
    }

    $id = intval($_GET['id']);

    $stmt = $conn->prepare("
        SELECT id, title, content, image_path, created_at
        FROM news 
        WHERE id = ?
    ");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $stmt->bind_result(
            $id,
            $title,
            $content,
            $imagePath,
            $created_at
        );

        if ($stmt->fetch()) {
            echo json_encode([
                "success"    => true,
                "id"         => $id,
                "title"      => $title,
                "content"    => $content,
                "image_path" => $imagePath,
                "created_at" => $created_at
            ]);
        } else {
            echo json_encode(["error" => true, "message" => "No data found"]);
        }
    } else {
        echo json_encode(["error" => true, "message" => "Query execution failed"]);
    }

    $stmt->close();
    $conn->close();
}
