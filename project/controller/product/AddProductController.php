<?php
session_start();

require_once __DIR__ . '/../../config/db_connection.php';
require __DIR__ . '/../../vendor/autoload.php';
use Picqer\Barcode\BarcodeGeneratorPNG;

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input data
    $name = trim($_POST['selected_product_name'] ?? '');
    $quantity = $_POST['product_quantity'] ?? 0;
    $date_produce = $_POST['product_date_produce'] ?? '';
    $date_expiration = date('Y-m-d', strtotime($date_produce . ' + 3 months'));
    $price = $_POST['product_price'] ?? 0;
    $unit = trim($_POST['product_unit_of_price'] ?? '');
    $category = trim($_POST['product_category'] ?? '');
    $status = 'new';

    $errors = [];

    // Validate required fields
    if (empty($name)) $errors[] = "Product name is required.";
    if (!is_numeric($quantity) || $quantity <= 0) $errors[] = "Quantity must be a positive number.";
    if (empty($date_produce)) $errors[] = "Production date is required.";
    if (!is_numeric($price) || $price <= 0) $errors[] = "Price must be a valid positive number.";
    if (empty($unit)) $errors[] = "Unit is required.";


    // If validation fails, return errors
    if (!empty($errors)) {
        echo json_encode(["status" => "error", "message" => $errors]);
        exit;
    }

    // Save Product & Barcode to Database
    $stmt = $conn->prepare("INSERT INTO products (quantity, product_name, date_produce, date_expiration, price, unit_of_price, category, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

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
