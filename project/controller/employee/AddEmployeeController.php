<?php
session_start();

require_once __DIR__ . '/../../config/db_connection.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $first_name = htmlspecialchars(trim($_POST["first_name"] ?? ""));
    $middle_initial = htmlspecialchars(trim($_POST["middle_initial"] ?? ""));
    $last_name = htmlspecialchars(trim($_POST["last_name"] ?? ""));
    $working_department = htmlspecialchars(trim($_POST["working_department"] ?? ""));
    $phone_number = htmlspecialchars(trim($_POST["phone_number"] ?? ""));
    $date_of_hire = htmlspecialchars($_POST["date_of_hire"] ?? "");
    $job = htmlspecialchars(trim($_POST["job"] ?? ""));
    $educational_level = htmlspecialchars(trim($_POST["educational_level"] ?? ""));
    $gender = htmlspecialchars(trim($_POST["gender"] ?? ""));
    $date_of_birth = htmlspecialchars($_POST["date_of_birth"] ?? "");
    $salary = filter_var($_POST["salary"] ?? 0, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $email = trim($_POST["employee_email"] ?? "");
    $password = htmlspecialchars(trim($_POST['employee_password'] ?? ""));
    $confirm_password = htmlspecialchars(trim($_POST['employee_confirm_password'] ?? ""));

    $errors = [];

    if (empty($first_name)) $errors[] = "First name is required.";
    if (empty($last_name)) $errors[] = "Last name is required.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if (!empty($phone_number)) {
        $pattern = '/^(?:\+63|0)[89]\d{9}$/';
    
        if (!preg_match($pattern, $phone_number)) {
            $errors[] = "Invalid phone number. Please use a valid Philippine phone number format (+63 or 0).";
        }
    }
    if (!empty($date_of_hire) && !strtotime($date_of_hire)) {
        $errors[] = "Invalid date format for date of hire."; 
    }
    if (!empty($date_of_birth) && !strtotime($date_of_birth)) {
        $errors[] = "Invalid date format for date of birth.";
    }
    if (!is_numeric($salary) || $salary < 0) {
        $errors[] = "Salary must be a valid positive number.";
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

    $checkEmailStmt = $conn->prepare("SELECT COUNT(*) AS count FROM employees WHERE email = ?");
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


    $sql = "INSERT INTO employees (
                first_name, middle_initial, last_name, working_department, 
                phone_number, date_of_hire, job, educational_level, 
                gender, date_of_birth, salary, email, password
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo json_encode(["error" => true, "message" => "Database error: " . $conn->error]);
        exit;
    }

    $stmt->bind_param(
        "ssssssssssdss", 
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
        $passwordHash
    );

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Employee data saved successfully!"]);
    } else {
        echo json_encode(["error" => true, "message" => "Failed to save employee data."]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["error" => true, "message" => "Invalid request method."]);
}