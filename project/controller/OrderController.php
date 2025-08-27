<?php
session_start();

require_once __DIR__ . '/../config/db_connection.php';
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../helper/helper.php';

header('Content-Type: application/json');

$orderNumber = generateOrderNumber($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $itemTotal = 0;
    $taxAmount = 0;
    $items = $_POST['items'];
    $message = '';
    foreach($items as $item){
        $id = $item['id'];
        $name = $item['name'];
        $quantity = (int) $item['quantity'];
        $price = (int) $item['price'];
        $unitOfPrice = $item['unit'];

        $itemTotal += calculateItemTotal($quantity, $price);

        $taxAmount = $itemTotal * 0.12;

        $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        for($i = 0; $i < count($results); $i++){
            $productID = (int) $results[$i]['id'];
            $productStock = (int) $results[$i]['total_quantity'];
            
            if ($productStock >= $quantity) {
                $deductedQuantity = $productStock - $quantity;

                $updateStmt = $conn->prepare('UPDATE products SET total_quantity = ? WHERE id = ?');
                $updateStmt->bind_param('ii', $deductedQuantity, $productID);
                $updateStmt->execute();

                if ($updateStmt->affected_rows === 0) {
                    $message = json_encode(['status' => 'error', 'message' => 'Failed to update stock for product ID: ' . $productID]);
                    echo $message;
                    exit;
                }
            } else {
                $message = json_encode(['status' => 'error', 'message' => "Insufficient stock for product: $name. Available: $productStock, Required: $quantity"]);
                echo $message;
                exit;
            }

        }

        $stmt = $conn->prepare('INSERT INTO orders (order_number, quantity, product_name, price, unit_of_price, tax_amount, total) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('sisdsdd', $orderNumber, $quantity, $name, $price, $unitOfPrice, $taxAmount, $itemTotal);
        $stmt->execute();

        if($stmt->affected_rows > 0) {
            $message = json_encode(['status' => 'success', 'message' => 'Orders saved']);
        }

        $stmt->close();
    }

    echo $message;

    $conn->close();
}
