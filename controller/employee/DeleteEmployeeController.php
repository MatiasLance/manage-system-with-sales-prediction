<?php
session_start();
require_once __DIR__ . '/../../config/db_connection.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
    exit;
}

if (!isset($_POST['password'], $_POST['id'])) {
    echo json_encode(['success' => false, 'message' => 'Password and employee ID are required.']);
    exit;
}

$password = trim($_POST['password']);
$employee_id = filter_var($_POST['id'], FILTER_VALIDATE_INT);

if (!$employee_id || $employee_id <= 0) {
    echo json_encode(['error' => true, 'message' => 'Invalid employee ID.']);
    exit;
}

$sql = "SELECT password FROM users WHERE user_type = 'admin' LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Admin user not found.']);
    exit;
}

$stmt->bind_result($hashed_password);
$stmt->fetch();
$stmt->close();

if (!password_verify($password, $hashed_password)) {
    echo json_encode(['success' => false, 'message' => 'Invalid password.']);
    exit;
}

$conn->begin_transaction();

try {
    $stmt = $conn->prepare("SELECT * FROM employees WHERE id = ?");
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $employee = $result->fetch_assoc();
    $stmt->close();

    if (!$employee) {
        echo json_encode(['success' => false, 'message' => 'Employee not found.']);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO archived_employees (
            id, first_name, middle_initial, last_name, working_department, 
            phone_number, date_of_hire, job, educational_level, 
            gender, date_of_birth, salary, email, created_at, updated_at, deleted_at
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
    ");

    $stmt->bind_param(
        "issssssssssdsss",
        $employee['id'],
        $employee['first_name'],
        $employee['middle_initial'],
        $employee['last_name'],
        $employee['working_department'],
        $employee['phone_number'],
        $employee['date_of_hire'],
        $employee['job'],
        $employee['educational_level'],
        $employee['gender'],
        $employee['date_of_birth'],
        $employee['salary'],
        $employee['email'],
        $employee['created_at'],
        $employee['updated_at']
    );

    $stmt->execute();

    if ($stmt->affected_rows <= 0) {
        echo json_encode(['error' => true, 'message' => 'Failed to archive employee.']);
    }
    $stmt->close();

    $stmt = $conn->prepare("DELETE FROM employees WHERE id = ?");
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();

    if ($stmt->affected_rows <= 0) {
        echo json_encode(['error' => true, 'message' => 'Failed to delete employee.']);
    }
    $stmt->close();

    $conn->commit();
    echo json_encode(['success' => true, 'message' => 'Employee Details Archived Successfully.']);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['error' => true, 'message' => $e->getMessage()]);
}

$conn->close();

