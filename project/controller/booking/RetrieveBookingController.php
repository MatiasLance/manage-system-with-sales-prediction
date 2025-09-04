<?php
session_start();
header("Content-Type: application/json");

require_once __DIR__ . '/../../config/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed"]);
    exit;
}

if (!isset($_GET['id']) || empty(trim($_GET['id']))) {
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
        b.booking_schedule,
        b.check_in,
        b.check_out,
        b.created_at AS booking_created_at,
        b.updated_at AS booking_updated_at,
        
        -- Room fields
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
    echo json_encode(["error" => "Database error: Unable to prepare statement"]);
    exit;
}

$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    http_response_code(404);
    echo json_encode(["error" => true, "message" => "Booking not found"]);
    $stmt->close();
    $conn->close();
    exit;
}

$booking = $result->fetch_assoc();
$stmt->close();
$conn->close();

$booking['booking_schedule'] = date('Y-m-d H:i:s', strtotime($booking['booking_schedule']));
$booking['booking_created_at'] = date('Y-m-d H:i:s', strtotime($booking['booking_created_at']));
$booking['booking_updated_at'] = date('Y-m-d H:i:s', strtotime($booking['booking_updated_at']));

if ($booking['room_created_at']) {
    $booking['room_created_at'] = date('Y-m-d H:i:s', strtotime($booking['room_created_at']));
    $booking['room_updated_at'] = date('Y-m-d H:i:s', strtotime($booking['room_updated_at']));
}

$fullName = trim("{$booking['first_name']} {$booking['middle_name']} {$booking['last_name']}");
$booking['full_name'] = $fullName;

$response = [
    'success' => true,
    'data' => [
        'booking' => [
            'id' => (int)$booking['id'],
            'full_name' => $fullName,
            'first_name' => $booking['first_name'],
            'middle_name' => $booking['middle_name'],
            'last_name' => $booking['last_name'],
            'email' => $booking['email'],
            'phone_number' => $booking['phone_number'],
            'status' => $booking['booking_status'],
            'guest_count' => (int)$booking['guest_count'],
            'booking_schedule' => $booking['booking_schedule'],
            'check_in' => $booking['check_in'] ?? null,
            'check_out' => $booking['check_out'] ?? null,
            'created_at' => $booking['booking_created_at'],
            'updated_at' => $booking['booking_updated_at']
        ],
        'room' => $booking['room_id'] ? [
            'id' => (int)$booking['room_id'],
            'room_number' => $booking['room_number'],
            'status' => $booking['room_status'],
            'created_at' => $booking['room_created_at'],
            'updated_at' => $booking['room_updated_at']
        ] : null
    ]
];

http_response_code(200);
echo json_encode($response, JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK);