<?php
session_start();
require_once __DIR__ . '/../config/db_connection.php';

header('Content-Type: application/json');

try {
    $start = $_GET['startDate'] ?? null;
    $end   = $_GET['endDate']   ?? null;


    if (empty($start) && empty($end)) {
        $today = new DateTime('today');
        $start = $today->format('Y-m-d');
        $end   = $today->format('Y-m-d');
    } else {
        $start = trim($start);
        $end   = trim($end);

        $validateDate = function ($dateStr, $field) {
            if (empty($dateStr)) {
                throw new InvalidArgumentException("Missing '$field' date.");
            }
            $dt = DateTime::createFromFormat('Y-m-d', $dateStr);
            if (!$dt || $dt->format('Y-m-d') !== $dateStr) {
                throw new InvalidArgumentException("Invalid '$field' date format. Use YYYY-MM-DD.");
            }
            return $dt;
        };

        $startObj = $validateDate($start, 'start');
        $endObj   = $validateDate($end, 'end');

        if ($startObj > $endObj) {
            throw new InvalidArgumentException("'start' date cannot be after 'end'.");
        }

        $start = $startObj->format('Y-m-d');
        $end   = $endObj->format('Y-m-d');
    }

    $startOfDay = $start . ' 00:00:00';
    $endOfDay   = $end . ' 23:59:59';

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
    if (!$stmt) {
        throw new Exception("Failed to prepare database query: " . $conn->error);
    }

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
            'tax_amount'     => (float)$row['tax_amount'],
            'total'          => (float)$row['total'],
            'created_at'     => $row['created_at']
        ];
    }

    echo json_encode([
        'status' => 'success',
        'range' => [
            'start' => $start,
            'end'   => $end
        ],
        'summary' => [
            'total_orders' => $totalCount,
            'total_sales'  => round($totalSales, 2)
        ],
        'data' => $orders
    ], JSON_PRETTY_PRINT);

} catch (InvalidArgumentException $e) {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request: ' . $e->getMessage()
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'An internal error occurred. Please try again later.'
    ]);
}

if (isset($stmt) && $stmt instanceof mysqli_stmt) {
    $stmt->close();
}
$conn->close();