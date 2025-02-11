<?php
session_start();
unset($_SESSION['id']);
// session_destroy();

echo json_encode([
    'success' => true,
    'message' => 'Logout successfully!'
]);