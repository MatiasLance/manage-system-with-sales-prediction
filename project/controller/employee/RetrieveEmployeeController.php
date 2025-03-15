<?php
session_start();
header("Content-Type: application/json");

require_once __DIR__ . '/../../config/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        echo json_encode(["error" => "Invalid ID"]);
        exit;
    }

    $id = intval($_GET['id']); // Ensure ID is an integer for security

    // Prepare the SQL query
    $stmt = $conn->prepare("
        SELECT first_name, middle_initial, last_name, working_department, 
               phone_number, date_of_hire, job, educational_level, 
               gender, date_of_birth, salary 
        FROM employees 
        WHERE id = ?
    ");
    $stmt->bind_param("i", $id);

    // Execute query
    if ($stmt->execute()) {
        // Bind result variables
        $stmt->bind_result(
            $first_name, $middle_initial, $last_name, $working_department, 
            $phone_number, $date_of_hire, $job, $educational_level, 
            $gender, $date_of_birth, $salary
        );

        // Fetch the result
        if ($stmt->fetch()) {
            echo json_encode([
                "first_name"         => $first_name,
                "middle_initial"     => $middle_initial,
                "last_name"          => $last_name,
                "working_department" => $working_department,
                "phone_number"       => $phone_number,
                "date_of_hire"       => $date_of_hire,
                "job"                => $job,
                "educational_level"  => $educational_level,
                "gender"             => $gender,
                "date_of_birth"      => $date_of_birth,
                "salary"             => $salary
            ]);
        } else {
            echo json_encode(["error" => true, "message" => "No data found"]);
        }
    } else {
        echo json_encode(["error" => true, "message" => "Query execution failed"]);
    }

    // Close connections
    $stmt->close();
    $conn->close();
}
?>
