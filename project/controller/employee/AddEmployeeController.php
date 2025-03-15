<?php
session_start();

require_once __DIR__ . '/../../config/db_connection.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and trim input
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

    // Validation rules
    $errors = [];

    if (empty($first_name)) $errors[] = "First name is required.";
    if (empty($last_name)) $errors[] = "Last name is required.";
    if (!empty($phone_number) && !preg_match('/^\d{10,15}$/', $phone_number)) {
        $errors[] = "Phone number must be 10-15 digits.";
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

    // Return errors if any
    if (!empty($errors)) {
        echo json_encode(["error" => true, "message" => $errors]);
        exit;
    }

    // Insert data using prepared statements
    $sql = "INSERT INTO employees (
                first_name, middle_initial, last_name, working_department, 
                phone_number, date_of_hire, job, educational_level, 
                gender, date_of_birth, salary
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo json_encode(["error" => true, "message" => "Database error: " . $conn->error]);
        exit;
    }

    $stmt->bind_param(
        "ssssssssssd", 
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
        $salary
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
?>
