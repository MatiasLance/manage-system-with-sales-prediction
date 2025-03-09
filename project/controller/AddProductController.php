<?php
session_start();

require_once __DIR__ . '/../config/db_connection.php';
require __DIR__ . '/../vendor/autoload.php';
use Picqer\Barcode\BarcodeGeneratorPNG;

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input data
    $name = trim($_POST['selected_product_name'] ?? '');
    $quantity = $_POST['product_quantity'] ?? 0;
    $date_produce = $_POST['product_date_produce'] ?? '';
    $date_expiration = $_POST['product_date_expiration'] ?? '';
    $price = $_POST['product_price'] ?? 0;
    $unit = trim($_POST['product_unit_of_price'] ?? '');

    $errors = [];

    // Validate required fields
    if (empty($name)) $errors[] = "Product name is required.";
    if (!is_numeric($quantity) || $quantity <= 0) $errors[] = "Quantity must be a positive number.";
    if (empty($date_produce)) $errors[] = "Production date is required.";
    if (empty($date_expiration)) $errors[] = "Expiration date is required.";
    if (!is_numeric($price) || $price <= 0) $errors[] = "Price must be a valid positive number.";
    if (empty($unit)) $errors[] = "Unit is required.";

    // Validate date format
    if (!empty($date_produce) && !empty($date_expiration)) {
        if (strtotime($date_produce) > strtotime($date_expiration)) {
            $errors[] = "Production date cannot be after expiration date.";
        }
    }

    // If validation fails, return errors
    if (!empty($errors)) {
        echo json_encode(["status" => "error", "message" => $errors]);
        exit;
    }

    // Generate a unique barcode using product name + random number
    $barcodeData = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $name)) . rand(100, 999);
    
    // Generate Barcode Image
    $generator = new BarcodeGeneratorPNG();
    $barcodeImage = $generator->getBarcode($barcodeData, $generator::TYPE_CODE_128);

    // Ensure barcode directory exists
    $barcodeDir = '../public/storage/barcode/';
    if (!is_dir($barcodeDir)) {
        mkdir($barcodeDir, 0777, true);
    }

    // Save Barcode Image
    $barcodePath = $barcodeDir . $barcodeData . ".png";
    if (!file_put_contents($barcodePath, $barcodeImage)) {
        echo json_encode(["status" => "error", "message" => "Failed to save barcode image."]);
        exit;
    }

    // Save Product & Barcode to Database
    $stmt = $conn->prepare("INSERT INTO products (quantity, product_name, date_produce, date_expiration, price, unit_of_price, barcode, barcode_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        echo json_encode(["status" => "error", "message" => "Database error: " . $conn->error]);
        exit;
    }

    $stmt->bind_param("isssdsss", $quantity, $name, $date_produce, $date_expiration, $price, $unit, $barcodeData, $barcodePath);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Product saved successfully!", "barcode" => str_replace(__DIR__, '', $barcodePath)]);
    } else {
        echo json_encode(["success" => false, "message" => "Error saving product: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
