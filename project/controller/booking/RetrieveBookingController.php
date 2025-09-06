<?php

session_start();
header("Content-Type: application/json");

require_once __DIR__ . '/../../config/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed"]);
    exit;
}

if (!isset($_GET['id']) || trim($_GET['id']) === '') {
    http_response_code(400);
    echo json_encode(["error" => "Booking ID is required"]);
    exit;
}

$id = intval($_GET['id']);
if ($id <= 0) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid booking ID"]);
    exit;
}

$sql = "
    SELECT 
        -- Booking fields
        b.id,
        b.first_name,
        b.middle_name,
        b.last_name,
        b.email,
        b.phone_number,
        b.status AS booking_status,
        b.guest_count,
        b.start_date,
        b.end_date,
        b.check_in,
        b.check_out,
        b.created_at AS booking_created_at,
        b.updated_at AS booking_updated_at,
        
        -- Room fields (if assigned)
        r.id AS room_id,
        r.room_number,
        r.status AS room_status,
        r.created_at AS room_created_at,
        r.updated_at AS room_updated_at
        
    FROM booking b
    LEFT JOIN room r ON b.room_id = r.id
    WHERE b.id = ?
";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    http_response_code(500);
    echo json_encode([
        "error" => true,
        "message" => "Database error: Unable to prepare statement"
    ]);
    exit;
}

$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    http_response_code(404);
    echo json_encode([
        "error" => true,
        "message" => "Booking not found"
    ]);
    $stmt->close();
    $conn->close();
    exit;
}

$booking = $result->fetch_assoc();
$stmt->close();
$conn->close();

$formatDate = function ($datetime) {
    return $datetime ? date('Y-m-d H:i', strtotime($datetime)) : null;
};

$formatTime = function ($time) {
    return $time ? date('H:i', strtotime($time)) : null;
};

$fullName = trim("{$booking['first_name']} {$booking['middle_name']} {$booking['last_name']}");

$response = [
    'success' => true,
    'data' => [
        'booking' => [
            'id' => (int)$booking['id'],
            'full_name' => $fullName,
            'first_name' => $booking['first_name'],
            'middle_name' => $booking['middle_name'] ?? null,
            'last_name' => $booking['last_name'],
            'email' => $booking['email'],
            'phone_number' => $booking['phone_number'],
            'status' => $booking['booking_status'],
            'guest_count' => (int)$booking['guest_count'],
            'start_date' => $formatDate($booking['start_date']),
            'end_date' => $formatDate($booking['end_date']),
            'check_in' => $formatTime($booking['check_in']),
            'check_out' => $formatTime($booking['check_out']),
            'created_at' => $formatDate($booking['booking_created_at']),
            'updated_at' => $formatDate($booking['booking_updated_at'])
        ],
        'room' => $booking['room_id'] ? [
            'id' => (int)$booking['room_id'],
            'room_number' => $booking['room_number'],
            'status' => $booking['room_status'],
            'created_at' => $formatDate($booking['room_created_at']),
            'updated_at' => $formatDate($booking['room_updated_at'])
        ] : null
    ]
];

http_response_code(200);
echo json_encode($response, JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK);