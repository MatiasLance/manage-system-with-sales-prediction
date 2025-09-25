<?php
session_start();
require_once __DIR__ . '/../../config/db_connection.php';

header('Content-Type: application/json');

if (!isset($_POST['password'], $_POST['id'])) {
    echo json_encode(['success' => false, 'message' => 'Password and product ID are required.']);
    exit;
}

$password = $_POST['password'];
$employee_id = (int)$_POST['id'];

$sql = "SELECT password FROM users WHERE user_type = 'admin' LIMIT 1";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($password_db);
        $stmt->fetch();

        if (password_verify($password, $password_db)) {
            $conn->begin_transaction();

            try {
                $sql_restore = "
                    INSERT INTO employees 
                    (id, first_name, middle_initial, last_name, working_department, phone_number, date_of_hire, job, educational_level, date_of_birth, salary, email, created_at, updated_at)
                    SELECT id, first_name, middle_initial, last_name, working_department, phone_number, date_of_hire, job, educational_level, date_of_birth, salary, email, created_at, updated_at
                    FROM archived_employees WHERE id = ?
                ";

                $stmt_restore = $conn->prepare($sql_restore);
                $stmt_restore->bind_param("i", $employee_id);
                $stmt_restore->execute();

                if ($stmt_restore->affected_rows > 0) {
                    $stmt_delete = $conn->prepare("DELETE FROM archived_employees WHERE id = ?");
                    $stmt_delete->bind_param("i", $employee_id);
                    $stmt_delete->execute();

                    if ($stmt_delete->affected_rows > 0) {
                        $conn->commit();
                        echo json_encode(['success' => true, 'message' => 'Employee restored successfully.']);
                    } else {
                        throw new Exception("Failed to remove employeed from archive.");
                    }

                    $stmt_delete->close();
                } else {
                    throw new Exception("Failed to restore employee.");
                }

                $stmt_restore->close();
            } catch (Exception $e) {
                $conn->rollback();
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid password.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Admin user not found.']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Error preparing query.']);
}

$conn->close();
