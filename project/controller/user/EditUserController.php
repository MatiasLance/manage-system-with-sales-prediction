<?php
session_start();
require_once __DIR__ . '/../../config/db_connection.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = (int)$_POST['user_id'];
    $first_name = htmlspecialchars(trim($_POST["first_name"] ?? ""));
    $last_name = htmlspecialchars(trim($_POST["last_name"] ?? ""));
    $email = trim($_POST["user_email"] ?? "");
    $userRole = htmlspecialchars(trim(strtolower($_POST["user_role"]) ?? ""));
    $password = trim($_POST['user_password'] ?? "");
    $confirm_password = trim($_POST['user_confirm_password'] ?? "");

    $errors = [];

    if (!$id || $id <= 0) {
        $errors[] = "Invalid User ID.";
    }
    if (empty($first_name)) {
        $errors[] = "First name is required.";
    }
    if (empty($last_name)) {
        $errors[] = "Last name is required.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if (!in_array($userRole, ['admin', 'manager', 'cashier'])) {
        $errors[] = "Invalid user role value.";
    }

    if (!empty($password) || !empty($confirm_password)) {
        if ($password !== $confirm_password) {
            $errors[] = "Password and confirm password do not match.";
        } elseif (strlen($password) < 8) {
            $errors[] = "Password must be at least 8 characters long.";
        }
    }

    if (!empty($errors)) {
        echo json_encode(["error" => true, "message" => $errors]);
        exit;
    }

    $check_user_stmt = $conn->prepare("SELECT COUNT(*) AS count FROM users WHERE id = ?");
    if (!$check_user_stmt) {
        echo json_encode(["error" => true, "message" => "Database error: " . $conn->error]);
        exit;
    }

    $check_user_stmt->bind_param("i", $id);
    $check_user_stmt->execute();
    $result = $check_user_stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['count'] === 0) {
        echo json_encode(["error" => true, "message" => "User not found."]);
        $check_user_stmt->close();
        $conn->close();
        exit;
    }

    $check_user_stmt->close();

    $check_email_stmt = $conn->prepare("SELECT COUNT(*) AS count FROM users WHERE email = ? AND id != ?");
    if (!$check_email_stmt) {
        echo json_encode(["error" => true, "message" => "Database error: " . $conn->error]);
        exit;
    }

    $check_email_stmt->bind_param("si", $email, $id);
    $check_email_stmt->execute();
    $result = $check_email_stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['count'] > 0) {
        echo json_encode(["error" => true, "message" => "Email already exists. Please use a unique email."]);
        $check_email_stmt->close();
        $conn->close();
        exit;
    }

    $check_email_stmt->close();

    $sql = "UPDATE users 
            SET firstname = ?, lastname = ?, email = ?, user_type = ?";
    
    if (!empty($password)) {
        $sql .= ", password = ?";
    }

    $sql .= " WHERE id = ?";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo json_encode(["error" => true, "message" => "Database error: " . $conn->error]);
        exit;
    }

    if (!empty($password)) {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $stmt->bind_param(
            "sssssi",
            $first_name,
            $last_name,
            $email,
            $userRole,
            $passwordHash,
            $id
        );
    } else {
        $stmt->bind_param(
            "sssssi",
            $first_name,
            $last_name,
            $email,
            $userRole,
            $passwordHash,
            $id
        );
    }

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "User details updated successfully!"]);
    } else {
        echo json_encode(["error" => true, "message" => "Error updating employee details: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["error" => true, "message" => "Invalid request method."]);
    exit;
}