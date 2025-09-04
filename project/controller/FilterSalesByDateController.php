<?php
session_start();
require_once __DIR__ . '/../config/db_connection.php';

header('Content-Type: application/json');

try {
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $items_per_page = isset($_GET['items_per_page']) ? (int)$_GET['items_per_page'] : 10;

    if ($page < 1) $page = 1;
    if ($items_per_page < 1) $items_per_page = 10;
    if ($items_per_page > 100) $items_per_page = 100;

    $offset = ($page - 1) * $items_per_page;

    $search = trim($_GET['search'] ?? '');
    $start = $_GET['startDate'] ?? null;
    $end = $_GET['endDate'] ?? null;


    if (empty($start) && empty($end)) {
        $today = new DateTime('today');
        $start = $today->format('Y-m-d');
        $end = $today->format('Y-m-d');
    } else {
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
        $endObj = $validateDate($end, 'end');

        if ($startObj > $endObj) {
            throw new InvalidArgumentException("'start' date cannot be after 'end'.");
        }

        $start = $startObj->format('Y-m-d');
        $end = $endObj->format('Y-m-d');
    }

    $startOfDay = $start . ' 00:00:00';
    $endOfDay = $end . ' 23:59:59';

    $whereConditions = [];
    $params = [];
    $types = '';

    $whereConditions[] = "deleted_at IS NULL";
    $whereConditions[] = "created_at >= ? AND created_at <= ?";
    $params[] = $startOfDay;
    $params[] = $endOfDay;
    $types .= 'ss';

    if (!empty($search)) {
        $searchParam = "%$search%";
        $whereConditions[] = "(order_number LIKE ? OR product_name LIKE ?)";
        $params[] = $searchParam;
        $params[] = $searchParam;
        $types .= 'ss';
    }

    $whereClause = implode(' AND ', $whereConditions);

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
        WHERE $whereClause
        ORDER BY created_at DESC
        LIMIT ? OFFSET ?
    ";

    $countQuery = "
        SELECT COUNT(*) AS total
        FROM orders
        WHERE $whereClause
    ";

    $stmtCount = $conn->prepare($countQuery);
    if (!$stmtCount) {
        throw new Exception("Failed to prepare count query: " . $conn->error);
    }

    $stmtCount->bind_param($types, ...$params);
    $stmtCount->execute();
    $resultCount = $stmtCount->get_result();
    $total_row = $resultCount->fetch_assoc();
    $total_items = (int)($total_row['total'] ?? 0);
    $stmtCount->close();

    $total_pages = $total_items > 0 ? ceil($total_items / $items_per_page) : 1;

    $finalParams = array_merge($params, [$items_per_page, $offset]);
    $finalTypes = $types . 'ii';

    $stmt = $conn->prepare($query);
    if (!$stmt) {
        throw new Exception("Failed to prepare data query: " . $conn->error);
    }

    $stmt->bind_param($finalTypes, ...$finalParams);
    $stmt->execute();
    $result = $stmt->get_result();

    $orders = [];
    $totalSales = 0.0;

    while ($row = $result->fetch_assoc()) {
        $floatTotal = (float)$row['total'];
        $totalSales += $floatTotal;

        $orders[] = [
            'id'             => (int)$row['id'],
            'order_number'   => $row['order_number'],
            'quantity'       => (int)$row['quantity'],
            'product_name'   => $row['product_name'],
            'price'          => (float)$row['price'],
            'unit_of_price'  => $row['unit_of_price'],
            'tax_amount'     => (float)$row['tax_amount'],
            'total'          => $floatTotal,
            'created_at'     => $row['created_at']
        ];
    }

    $response = [
        'status' => 'success',
        'range' => [
            'start' => $start,
            'end'   => $end
        ],
        'pagination' => [
            'current_page'  => $page,
            'items_per_page' => $items_per_page,
            'total_pages'   => $total_pages,
            'total_items'   => $total_items,
            'has_next'      => $page < $total_pages,
            'has_prev'      => $page > 1
        ],
        'summary' => [
            'total_orders' => count($orders),
            'total_sales'  => round($totalSales, 2)
        ],
        'data' => $orders
    ];

    echo json_encode($response, JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK);

} catch (InvalidArgumentException $e) {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request: ' . $e->getMessage()
    ], JSON_PRETTY_PRINT);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'An internal error occurred. Please try again later.'
    ], JSON_PRETTY_PRINT);
}

if (isset($stmt) && $stmt instanceof mysqli_stmt) {
    $stmt->close();
}
$conn->close();