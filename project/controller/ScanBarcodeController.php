<?php
require_once __DIR__ . '/../../config/db_connection.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $scannedCode = $_GET['code'] ?? '';

    if (empty($scannedCode)) {
        echo json_encode(["status" => "error", "message" => "No barcode scanned."]);
        exit;
    }

    $stmt = $conn->prepare("SELECT p.*, pn.product_name 
                            FROM products p
                            JOIN products_name pn ON p.product_name_id = pn.id
                            WHERE p.barcode = ?");
    
    $stmt->bind_param("s", $scannedCode);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode([
            "status" => "success",
            "data" => [
                "product_name" => $row['product_name'],
                "quantity" => $row['total_quantity'],
                "price" => $row['price'],
                "unit" => $row['unit_of_price'],
                "date_produce" => $row['date_produce'],
                "date_expiration" => $row['date_expiration'],
                "status" => $row['status'],
                "barcode_image" => $row['barcode_image']
            ]
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "Product not found."]);
    }

    $stmt->close();
    $conn->close();
}