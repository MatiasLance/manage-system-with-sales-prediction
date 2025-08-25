<?php
session_start();
require_once __DIR__ . '/../config/db_connection.php';

header('Content-Type: application/json');

try {
    if (!isset($_GET['date']) || empty(trim($_GET['date']))) {
        http_response_code(400);
        echo json_encode([
            'status' => 'error',
            'message' => 'Date parameter is required.'
        ]);
        exit;
    }

    $inputDate = trim($_GET['date']);

    $dateObj = DateTime::createFromFormat('Y-m-d', $inputDate);
    if (!$dateObj || $dateObj->format('Y-m-d') !== $inputDate) {
        http_response_code(400);
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid date format. Use YYYY-MM-DD.'
        ]);
        exit;
    }

    $startOfDay = $inputDate . ' 00:00:00';
    $endOfDay   = $inputDate . ' 23:59:59';

    $query = "
        SELECT 
            id,
            order_number,
            quantity,
            product_name,
            price,
            unit_of_price,
            tax_amount,
            total,
            created_at
        FROM orders 
        WHERE deleted_at IS NULL 
          AND created_at >= ?
          AND created_at <= ?
        ORDER BY created_at DESC
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $startOfDay, $endOfDay);
    $stmt->execute();
    $result = $stmt->get_result();

    $orders = [];
    $totalSales = 0.0;
    $totalCount = 0;

    while ($row = $result->fetch_assoc()) {
        $totalSales += (float)$row['total'];
        $totalCount++;

        $orders[] = [
            'id'             => (int)$row['id'],
            'order_number'   => $row['order_number'],
            'quantity'       => (int)$row['quantity'],
            'product_name'   => $row['product_name'],
            'price'          => (float)$row['price'],
            'unit_of_price'  => $row['unit_of_price'],
            'tax_amount'     => $row['tax_amount'],
            'total'          => (float)$row['total'],
            'created_at'     => $row['created_at']
        ];
    }

    echo json_encode([
        'status' => 'success',
        'data' => $orders
    ], JSON_PRETTY_PRINT);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}

$conn->close();