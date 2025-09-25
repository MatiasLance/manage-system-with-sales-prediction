<?php
session_start();
require_once __DIR__ . '/../config/db_connection.php';

$response = [
    'success' => false,
    'message' => 'Logout failed.',
    'redirect' => null
];

$status = 'Inactive';

try {
    if (isset($_SESSION['id'])) {
        $userId = $_SESSION['id'];
        $role = $_SESSION['user_role'] ?? 'unknown';

        $updateQuery = "UPDATE login_history SET status = ?, updated_at = NOW() WHERE user_id = ? AND status = 'Active'";
        $stmt = $conn->prepare($updateQuery);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("si", $status, $userId);

        if ($stmt->execute()) {
            $affectedRows = $stmt->affected_rows;
            error_log("Logged out user ID $userId. Updated $affectedRows active sessions.");
        } else {
            throw new Exception("Update failed: " . $stmt->error);
        }

        $stmt->close();

        unset($_SESSION['id']);
        unset($_SESSION['firstname']);
        unset($_SESSION['lastname']);
        unset($_SESSION['user_role']);

        $response['message'] = 'Admin/Manager logged out successfully.';
        $response['redirect'] = '/admin';

    } elseif (isset($_SESSION['cashier_id'])) {
        $cashierId = $_SESSION['cashier_id'];

        $updateQuery = "UPDATE login_history SET status = ?, updated_at = ? WHERE user_id = ? AND status = 'Active'";
        $stmt = $conn->prepare($updateQuery);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("si", $status, NOW(), $cashierId);

        if ($stmt->execute()) {
            $affectedRows = $stmt->affected_rows;
            error_log("Logged out cashier ID $cashierId. Updated $affectedRows active sessions.");
        } else {
            throw new Exception("Update failed: " . $stmt->error);
        }

        $stmt->close();

        unset($_SESSION['cashier_id']);
        unset($_SESSION['cashier_name']);

        $response['message'] = 'Cashier logged out successfully.';
        $response['redirect'] = '/';

    } else {
        $response['message'] = 'No active session found.';
    }

    session_unset();
    session_destroy();

    $response['success'] = true;

} catch (Exception $e) {
    error_log("Logout error: " . $e->getMessage());
    $response['message'] = 'An error occurred during logout.';
}

header('Content-Type: application/json');
echo json_encode($response);