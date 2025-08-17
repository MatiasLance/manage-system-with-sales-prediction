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
        SELECT firstname, lastname, email, user_type
        FROM users 
        WHERE id = ?
    ");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $stmt->bind_result(
            $firstname, $lastname, $email, $user_type
        );

        if ($stmt->fetch()) {
            echo json_encode([
                "first_name"         => $firstname,
                "last_name"          => $lastname,
                "email"              => $email,
                "user_type"          => $user_type
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
