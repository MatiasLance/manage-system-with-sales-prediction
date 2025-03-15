<?php
session_start();
require_once __DIR__ . '/../../config/db_connection.php';

header('Content-Type: application/json');

// Check if request is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and validate input data
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

    // Array to store errors
    $errors = [];

    // Validation checks
    if (!$id || $id <= 0) {
        $errors[] = "Invalid Employee ID.";
    }
    if (empty($first_name)) {
        $errors[] = "First name is required.";
    }
    if (empty($last_name)) {
        $errors[] = "Last name is required.";
    }
    if (!preg_match("/^(09|63)\d{9}$/", $phone_number)) {
        $errors[] = "Invalid phone number format. Must start with '09' or '63' and be 11 digits long.";
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

    // If there are errors, stop execution
    if (!empty($errors)) {
        echo json_encode(["error" => true, "message" => $errors]);
        exit;
    }

    // Check if the employee exists before updating
    $check_stmt = $conn->prepare("SELECT COUNT(*) FROM employees WHERE id = ?");
    $check_stmt->bind_param("i", $id);
    $check_stmt->execute();
    $check_stmt->bind_result($employeeCount);
    $check_stmt->fetch();
    $check_stmt->close();

    if ($employeeCount === 0) {
        echo json_encode(["error" => true, "message" => "Employee not found."]);
        exit;
    }

    // Update query with prepared statement
    $sql = "UPDATE employees 
            SET first_name = ?, middle_initial = ?, last_name = ?, working_department = ?, 
                phone_number = ?, date_of_hire = ?, job = ?, educational_level = ?, 
                gender = ?, date_of_birth = ?, salary = ?
            WHERE id = ?";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo json_encode(["error" => true, "message" => "Database error: " . $conn->error]);
        exit;
    }

    $stmt->bind_param(
        "ssssssssssdi",
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
        $id
    );

    // Execute the statement
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Employee details updated successfully!"]);
    } else {
        echo json_encode(["error" => true, "message" => "Error updating employee details: " . $stmt->error]);
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["error" => true, "message" => "Invalid request method."]);
    exit;
}
?>
