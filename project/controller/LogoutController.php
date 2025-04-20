<?php
session_start();

$response = [
    'success' => false,
    'message' => 'Logout failed.',
    'redirect' => null
];

if (isset($_SESSION['id'])) {
    unset($_SESSION['id']);
    $response['message'] = 'Admin logged out successfully.';
    $response['redirect'] = '/admin';
} elseif (isset($_SESSION['cashier_id'])) {
    unset($_SESSION['cashier_id']);
    $response['message'] = 'Cashier logged out successfully.';
    $response['redirect'] = '/'; 
} else {
    $response['message'] = 'No active session found.';
}
session_destroy();

if ($response['message'] !== 'Logout failed.') {
    $response['success'] = true;
}

header('Content-Type: application/json');
echo json_encode($response);
?>