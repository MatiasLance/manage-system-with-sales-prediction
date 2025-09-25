<?php
session_start();
require_once __DIR__ . '/../../config/db_connection.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $first_name = htmlspecialchars(trim($_POST["first_name"] ?? ""));
    $middle_initial = htmlspecialchars(trim($_POST["middle_initial"] ?? ""));
    $last_name = htmlspecialchars(trim($_POST["last_name"] ?? ""));
    $working_department = htmlspecialchars(trim($_POST["working_department"] ?? ""));
    $phone_number = htmlspecialchars(trim($_POST["phone_number"] ?? ""));
    $date_of_hire = htmlspecialchars(trim($_POST["date_of_hire"] ?? ""));
    $job = htmlspecialchars(trim($_POST["job"] ?? ""));
    $educational_level = htmlspecialchars(trim($_POST["educational_level"] ?? ""));
    $gender = htmlspecialchars(trim($_POST["gender"] ?? ""));
    $date_of_birth = htmlspecialchars(trim($_POST["date_of_birth"] ?? ""));
    $salary = filter_input(INPUT_POST, 'salary', FILTER_VALIDATE_FLOAT);
    $email = trim($_POST["employee_email"] ?? "");

    $errors = [];

    if (!$id || $id <= 0) {
        $errors[] = "Invalid Employee ID.";
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
    if (!empty($phone_number)) {
        $pattern = '/^(?:\+63|0)[89]\d{9}$/';
        if (!preg_match($pattern, $phone_number)) {
            $errors[] = "Invalid phone number. Please use a valid Philippine phone number format (+63 or 0).";
        }
    }
    if (!in_array(strtolower($gender), ['male', 'female', 'other'])) {
        $errors[] = "Invalid gender value.";
    }
    if (!empty($date_of_hire) && !strtotime($date_of_hire)) {
        $errors[] = "Invalid date of hire format.";
    }
    if (!empty($date_of_birth) && !strtotime($date_of_birth)) {
        $errors[] = "Invalid date of birth format.";
    }

    if (!empty($errors)) {
        echo json_encode(["error" => true, "message" => $errors]);
        exit;
    }

    $check_employee_stmt = $conn->prepare("SELECT COUNT(*) AS count FROM employees WHERE id = ?");
    if (!$check_employee_stmt) {
        echo json_encode(["error" => true, "message" => "Database error: " . $conn->error]);
        exit;
    }

    $check_employee_stmt->bind_param("i", $id);
    $check_employee_stmt->execute();
    $result = $check_employee_stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['count'] === 0) {
        echo json_encode(["error" => true, "message" => "Employee not found."]);
        $check_employee_stmt->close();
        $conn->close();
        exit;
    }

    $check_employee_stmt->close();

    $check_email_stmt = $conn->prepare("SELECT COUNT(*) AS count FROM employees WHERE email = ? AND id != ?");
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

    $sql = "UPDATE employees 
            SET first_name = ?, middle_initial = ?, last_name = ?, working_department = ?, 
                phone_number = ?, date_of_hire = ?, job = ?, educational_level = ?, 
                gender = ?, date_of_birth = ?, salary = ?, email = ?";
    
    $sql .= " WHERE id = ?";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo json_encode(["error" => true, "message" => "Database error: " . $conn->error]);
        exit;
    }

    $stmt->bind_param(
        "ssssssssssdsi",
        $first_name,
        $middle_initial,
        $last_name,
        $working_department,
        $phone_number,
        $date_of_hire,
        $job,
        $educational_level,
        $gender,
        $date_of_birth,
        $salary,
        $email,
        $id
    );

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Employee details updated successfully!"]);
    } else {
        echo json_encode(["error" => true, "message" => "Error updating employee details: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["error" => true, "message" => "Invalid request method."]);
    exit;
}