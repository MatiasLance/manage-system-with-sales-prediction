<?php
session_start();

require_once __DIR__ . '/../../config/db_connection.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $first_name = htmlspecialchars(trim($_POST["first_name"] ?? ""));
    $last_name = htmlspecialchars(trim($_POST["last_name"] ?? ""));
    $email = trim($_POST["user_email"] ?? "");
    $userRole = htmlspecialchars(trim(strtolower($_POST["user_role"]) ?? ""));
    $password = htmlspecialchars(trim($_POST['user_password'] ?? ""));
    $confirm_password = htmlspecialchars(trim($_POST['user_confirm_password'] ?? ""));

    $errors = [];

    if (empty($first_name)) $errors[] = "First name is required.";
    if (empty($last_name)) $errors[] = "Last name is required.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if (!in_array($userRole, ['admin', 'manager', 'cashier'])) {
        $errors[] = "Invalid user role value.";
    }

    if (empty($password)) {
        $errors[] = "Password is required.";
    } elseif ($password !== $confirm_password) {
        $errors[] = "Password did not match.";
    }

    if (!empty($errors)) {
        echo json_encode(["error" => true, "message" => $errors]);
        exit;
    }

    $checkEmailStmt = $conn->prepare("SELECT COUNT(*) AS count FROM users WHERE email = ?");
    if (!$checkEmailStmt) {
        echo json_encode(["error" => true, "message" => "Database error: " . $conn->error]);
        exit;
    }

    $checkEmailStmt->bind_param("s", $email);
    $checkEmailStmt->execute();
    $result = $checkEmailStmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['count'] > 0) {
        echo json_encode(["error" => true, "message" => "Email already exists. Please use a unique email."]);
        $checkEmailStmt->close();
        $conn->close();
        exit;
    }

    $checkEmailStmt->close();

    $passwordHash = password_hash($password, PASSWORD_BCRYPT);


    $sql = "INSERT INTO users (
                firstname, lastname, email, 
                password, user_type) VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo json_encode(["error" => true, "message" => "Database error: " . $conn->error]);
        exit;
    }

    $stmt->bind_param(
        "sssss", 
        $first_name, 
        $last_name, 
        $email,
        $passwordHash,
        $userRole
    );

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "User " . $first_name . " " . $last_name . " data saved successfully!"]);
    } else {
        echo json_encode(["error" => true, "message" => "Failed to save user data."]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["error" => true, "message" => "Invalid request method."]);
}