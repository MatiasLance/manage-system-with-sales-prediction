<?php
session_start();

require_once __DIR__ . '/../../config/db_connection.php';
require __DIR__ . '/../../vendor/autoload.php';
use Picqer\Barcode\BarcodeGeneratorPNG;

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $addedQuantity = $_POST['product_quantity'] ?? 0;
    $name = isset($_POST['selected_product_name_id']) ? (int)$_POST['selected_product_name_id'] : 0;
    $date_produce = $_POST['product_date_produce'] ?? '';
    $price = $_POST['product_price'] ?? 0;
    $unit = trim($_POST['product_unit_of_price'] ?? '');
    $status = 'new';

    // Calculate expiration date (3 months after production date)
    $date_expiration = date('Y-m-d', strtotime($date_produce . ' + 3 months'));

    $errors = [];

    if (!is_numeric($addedQuantity) || $addedQuantity <= 0) $errors[] = "Quantity must be a positive number.";
    if (empty($date_produce)) $errors[] = "Production date is required.";
    if (!is_numeric($price) || $price <= 0) $errors[] = "Price must be a valid positive number.";
    if (empty($unit)) $errors[] = "Unit is required.";


    if (!empty($errors)) {
        echo json_encode(["status" => "error", "message" => $errors]);
        exit;
    }

    $productNameQuery = $conn->prepare("SELECT product_name, product_code, product_category FROM products_name WHERE id = ?");
    $productNameQuery->bind_param('i', $name);

    if($productNameQuery->execute()){
        $productNameQueryResult = $productNameQuery->get_result();
        $productNameQueryRow = $productNameQueryResult->fetch_assoc();

        // Generate a unique barcode using product name + random number
        $barcodeData = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $productNameQueryRow['product_code'])) . rand(100, 999);

        // Generate Barcode Image
        $generator = new BarcodeGeneratorPNG();
        $barcodeImage = $generator->getBarcode($barcodeData, $generator::TYPE_CODE_128, 3, 50);

        // Ensure barcode directory exists
        $barcodeDir = '../../public/storage/barcode/';
        if (!is_dir($barcodeDir)) {
            mkdir($barcodeDir, 0777, true);
        }

        // Save Barcode Image
        $barcodePath = $barcodeDir . $barcodeData . ".png";
        if (!file_put_contents($barcodePath, $barcodeImage)) {
            echo json_encode(["status" => "error", "message" => "Failed to save barcode image."]);
            exit;
        }

        $stmt = $conn->prepare("INSERT INTO products (total_quantity, added_quantity, product_name_id, date_produce, date_expiration, price, unit_of_price, barcode, barcode_image, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        if (!$stmt) {
            echo json_encode(["status" => "error", "message" => "Database error: " . $conn->error]);
            exit;
        }

        $stmt->bind_param("iiissdssss", $addedQuantity, $addedQuantity, $name, $date_produce, $date_expiration, $price, $unit, $barcodeData, $barcodePath, $status);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Product saved successfully!", "barcode" => str_replace(__DIR__, '', $barcodePath)]);
        } else {
            echo json_encode(["success" => false, "message" => "Error saving product: " . $stmt->error]);
        }
    }

    $productNameQuery->close();
    $stmt->close();
    $conn->close();
}
