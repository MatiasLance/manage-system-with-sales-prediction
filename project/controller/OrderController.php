<?php
session_start();

require_once __DIR__ . '/../config/db_connection.php';
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../helper/helper.php';

use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\FilePrintConnector; // For Linux USB
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector; // For Wireless Printer
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector; // For Windows (10, 11)

header('Content-Type: application/json');

// $ip = '192.168.1.100'; Example rani na IP need ninyo e butang ang exact IP sa printer device
// $port = 9100; Ibutang ang exact port sa printer.
// $printerName = ''; Gamit rani if naka window ang OS. Uncomment ni if gusto gamiton then ibutang ang printer name (e.g., "EPSON TM-T88V").

// $connector = new NetworkPrintConnector($ip, $port); // Uncomment if wireless printer ang gamiton
// $connector = new WindowsPrintConnector($printerName); // Uncomment if window os ang gamiton sa pag print
$connector = new FilePrintConnector("/dev/usb/lp0"); // Linux ni siya na printer connector so ug wala naka linux OS comment rani na code.
$printer = new Printer($connector);
$date = date('l jS \of F Y h:i:s A');
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
            $productStock = (int) $results[$i]['quantity'];
            $deductedQuantity = (int) $productStock - (int) $quantity;

            $stmt = $conn->prepare('UPDATE products SET quantity = ? WHERE id = ?');
            $stmt->bind_param('ii', $deductedQuantity, $productID);
            $stmt->execute();
            if($stmt->affected_rows === 0) {
                $message = json_encode(['status' => 'error', 'message' => 'No rows updated']);
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

        // Print the receipt
        try {
            $logo = EscposImage::load("https://i.imgur.com/3LvoZ6D.png", false);
            $printer = new Printer($connector);

            /* Print top logo */
            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> graphics($logo);

            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("Thank You for Shopping\n");
            $printer->text("Order Number: $orderNumber\n");
            $printer->text("$date\n");
            $printer->text("--------------------------------\n");
    
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            foreach ($items as $item) {
                $itemName = $item['name'];
                $itemQuantity = $item['quantity'];
                $itemPrice = $item['price'];
                $itemUnit = $item['unit'];
                $itemSubtotal = calculateItemTotal($itemQuantity, $itemPrice);
    
                $printer->text("$itemName ($itemUnit)\n");
                $printer->text("Qty: $itemQuantity | Price: $$itemPrice | Subtotal: $$itemSubtotal\n");
            }
    
            $printer->text("--------------------------------\n");
            $printer->setJustification(Printer::JUSTIFY_RIGHT);
            $printer->text("Tax: $" . number_format($taxAmount, 2) . "\n");
            $printer->text("Total: $" . number_format($itemTotal + $taxAmount, 2) . "\n");
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("Come Again Soon!\n");
    
            $printer->cut();
    
        } catch (Exception $e) {
            $message = json_encode(['status' => 'error', 'message' => 'Printing failed: ' . $e->getMessage()]);
        } finally {
            $printer->close();
        }

    echo $message;

    $conn->close();
}
