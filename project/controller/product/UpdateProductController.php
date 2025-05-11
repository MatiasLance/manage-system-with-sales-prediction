<?php
session_start();
require_once __DIR__ . '/../../config/db_connection.php';
require_once __DIR__ . '/../../helper/helper.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $addedQuantity = isset($_POST['product_added_quantity']) && is_numeric($_POST['product_added_quantity']) ? (int)$_POST['product_added_quantity'] : 0;
    $product_name_id = isset($_POST['product_name_id']) ? (int)$_POST['product_name_id'] : 0;
    $date_produce = $_POST['product_date_produce'] ?? '';
    $date_expiration = formattedDate($_POST['product_date_expiration']) ?? '';
    $price = isset($_POST['product_price']) && is_numeric($_POST['product_price']) ? (float)$_POST['product_price'] : 0;
    $unit = trim($_POST['product_unit_of_price'] ?? '');

    $errors = [];

    if ($id <= 0) $errors[] = "Invalid product ID.";
    if ($product_name_id <= 0) $errors[] = "Invalid product name ID.";
    if ($addedQuantity < 0) $errors[] = "Quantity must be a positive number.";
    if (empty($date_produce)) $errors[] = "Production date is required.";
    if (empty($date_expiration)) $errors[] = "Expiration date is required.";
    if ($price <= 0) $errors[] = "Price must be a valid positive number.";
    if (empty($unit)) $errors[] = "Unit is required.";
    if (!empty($date_produce) && !empty($date_expiration) && strtotime($date_produce) > strtotime($date_expiration)) {
        $errors[] = "Production date cannot be after expiration date.";
    }

    if (!empty($errors)) {
        echo json_encode(["status" => "error", "message" => $errors]);
        exit;
    }

    $selectProductStatement = $conn->prepare("SELECT total_quantity, added_quantity FROM products WHERE id = ?");
    $selectProductStatement->bind_param('i', $id);
    $selectProductStatement->execute();
    $result = $selectProductStatement->get_result();

    $db_total_quantity = [];
    $db_added_quantity = [];
    if($result->num_rows >  0){
        while($row = $result->fetch_assoc()){
            $db_total_quantity[] = $row['total_quantity'];
            $db_added_quantity[] = $row['added_quantity'];
        }
    }

    $newTotalQuantity = $addedQuantity !== 0 ? $addedQuantity + $db_total_quantity[0]: $db_total_quantity[0];
    $newAddedQuantity = $addedQuantity !== 0 ? $addedQuantity: $db_added_quantity[0];

    $stmt = $conn->prepare("
        UPDATE products 
        SET total_quantity = ?, added_quantity = ?, product_name_id = ?, date_produce = ?, date_expiration = ?, price = ?, unit_of_price = ?
        WHERE id = ?
    ");

    if (!$stmt) {
        echo json_encode(["status" => "error", "message" => "Database error: " . $conn->error]);
        exit;
    }

    $stmt->bind_param("iiissdsi", $newTotalQuantity, $newAddedQuantity, $product_name_id, $date_produce, $date_expiration, $price, $unit, $id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Product updated successfully!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error updating product: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>
