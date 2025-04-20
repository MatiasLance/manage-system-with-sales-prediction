<?php

function formattedDate($inputDate){
    $date = DateTime::createFromFormat('m/d/Y', $inputDate);
    $formattedDate = $date->format('Y-m-d');
    return $formattedDate;
}

function calculateItemTotal($quantity, $price){
    return (int) $price * (int) $quantity;
}

/**
 * Checks if the input quantity is valid (not greater than the available stock).
 *
 * @param mixed $quantity The quantity input by the user.
 * @param mixed $stock The available stock of the product.
 * @return bool Returns true if the quantity is valid, false otherwise.
 */
function isValidProductQuantityInput($quantity, $stock): bool {
    $quantity = (int) $quantity;
    $stock = (int) $stock;

    if ($quantity < 0 || $stock < 0) {
        return false;
    }

    if ($quantity > $stock) {
        return false;
    }

    return true;
}

function generateOrderNumber($conn, $prefix = "ORD") {
    $stmt = $conn->prepare("SELECT MAX(id) AS last_order_id FROM orders");
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $lastOrderId = $row['last_order_id'] ?? 0;
    $newOrderId = $lastOrderId + 1;

    return sprintf("%s-%06d", $prefix, $newOrderId);
}