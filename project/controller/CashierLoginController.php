<?php
session_start();

require_once __DIR__ . '/../config/db_connection.php';

header('Content-Type: application/json');

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $userRole = 'cashier';

    $sql = "SELECT id, firstname, lastname, email, password, user_type FROM users WHERE email = ? AND user_type = ? LIMIT 1";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ss", $email, $userRole);

        $stmt->execute();

        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $firstname, $lastname, $email_db, $password_db, $userType);

            $stmt->fetch();

            if (password_verify($password, $password_db)) {
                $_SESSION['cashier_id'] = $id;
                $_SESSION['firstname'] = $firstname;
                $_SESSION['lastname'] = $lastname;
                $_SESSION['user_role'] = $userType;
                echo json_encode([
                    'success' => true,
                    'message' => 'Login successful!',
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Invalid password.'
                ]);
            }
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'No user found with this email.'
            ]);
        }

        $stmt->close();
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Error preparing the query.'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Email and password are required.'
    ]);
}

$conn->close();
