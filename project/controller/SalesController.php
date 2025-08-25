<?php
session_start();
require_once __DIR__ . '/../config/db_connection.php';

header('Content-Type: application/json');

try {
    $reports = [];

    function getSalesData($conn, $days, $groupByClause, $dateFormat) {
        $sinceDate = date('Y-m-d H:i:s', strtotime("-{$days} days"));

        $query = "
            SELECT 
                {$groupByClause} AS period,
                product_name,
                SUM(total) AS total_sales
            FROM orders 
            WHERE deleted_at IS NULL 
              AND created_at >= ?
            GROUP BY period, product_name
            ORDER BY period DESC, total_sales DESC
        ";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $sinceDate);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];

        while ($row = $result->fetch_assoc()) {
            $rawPeriod = $row['period'];
            $productName = $row['product_name'];
            $totalSales = (float)$row['total_sales'];

            $formattedPeriod = $dateFormat
                ? date($dateFormat, strtotime($rawPeriod))
                : $rawPeriod;

            if (!isset($data[$rawPeriod])) {
                $data[$rawPeriod] = [
                    'period' => $formattedPeriod,
                    'total_sales' => 0,
                    'products' => []
                ];
            }

            $data[$rawPeriod]['total_sales'] += $totalSales;

            $data[$rawPeriod]['products'][] = [
                'product_name' => $productName,
                'total_sales' => $totalSales
            ];
        }

        return array_values($data);
    }

    $weeklyGroupBy = "DATE(created_at)";
    $weeklyDateFormat = "M j, Y";
    $reports['weekly'] = getSalesData($conn, 7, $weeklyGroupBy, $weeklyDateFormat);

    $monthlyGroupBy = "DATE(created_at)";
    $monthlyDateFormat = "M j, Y";
    $reports['monthly'] = getSalesData($conn, 30, $monthlyGroupBy, $monthlyDateFormat);

    $yearlyGroupBy = "YEAR(created_at)";
    $yearlyDateFormat = "Y";
    $reports['yearly'] = getSalesData($conn, 365, $yearlyGroupBy, $yearlyDateFormat);

    echo json_encode([
        'status' => 'success',
        'data' => $reports
    ], JSON_PRETTY_PRINT);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}

if (isset($conn)) {
    $conn->close();
}