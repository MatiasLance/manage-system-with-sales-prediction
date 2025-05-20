<?php
session_start();
require_once __DIR__ . '/../config/db_connection.php';

header('Content-Type: application/json');

try {
    $reports = [];

    function getSalesData($conn, $groupByClause, $dateFormat = null) {
        $query = "SELECT 
                    {$groupByClause} AS period,
                    product_name,
                    SUM(total) AS total_sales
                  FROM orders 
                  WHERE deleted_at IS NULL 
                  GROUP BY period, product_name, price";

        $result = $conn->query($query);
        $data = [];

        while ($row = $result->fetch_assoc()) {
            $period = $row['period'];
            $productName = $row['product_name'];
            $totalSales = (float)$row['total_sales'];

            if (!isset($data[$period])) {
                $data[$period] = [
                    'period' => $dateFormat ? date($dateFormat, strtotime($period)) : $period,
                    'total_sales' => 0,
                    'products' => []
                ];
            }

            $data[$period]['total_sales'] += $totalSales;

            $data[$period]['products'][] = [
                'product_name' => $productName,
                'total_sales' => $totalSales
            ];
        }

        return array_values($data);
    }

    $weeklyQueryGroupBy = "DATE_FORMAT(created_at, '%Y-%U')";
    $weeklyDateFormat = "Y-\$U";
    $reports['weekly'] = getSalesData($conn, $weeklyQueryGroupBy, $weeklyDateFormat);

    $monthlyQueryGroupBy = "DATE_FORMAT(created_at, '%Y-%m')";
    $monthlyDateFormat = "F Y";
    $reports['monthly'] = getSalesData($conn, $monthlyQueryGroupBy, $monthlyDateFormat);

    $yearlyQueryGroupBy = "YEAR(created_at)";
    $yearlyDateFormat = "Y";
    $reports['yearly'] = getSalesData($conn, $yearlyQueryGroupBy, $yearlyDateFormat);

    echo json_encode([
        'status' => 'success',
        'data' => $reports
    ]);

} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}

$conn->close();