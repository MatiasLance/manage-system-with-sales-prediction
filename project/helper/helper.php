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

function parseBookingDateRange($rangeStr) {
    $rangeStr = trim($rangeStr);
    $parts = preg_split('/\s*-\s*/', $rangeStr, 2);

    if (count($parts) !== 2) {
        throw new InvalidArgumentException("Invalid date range format. Expected 'MM/DD/YYYY - MM/DD/YYYY'.");
    }

    [$startStr, $endStr] = $parts;

    $startDate = DateTime::createFromFormat('m/d/Y', trim($startStr));
    $endDate   = DateTime::createFromFormat('m/d/Y', trim($endStr));

    $errors = [];

    if (!$startDate) {
        $errors[] = "Invalid start date: '{$startStr}'. Use MM/DD/YYYY.";
    }
    if (!$endDate) {
        $errors[] = "Invalid end date: '{$endStr}'. Use MM/DD/YYYY.";
    }

    if (!empty($errors)) {
        throw new InvalidArgumentException(implode(" ", $errors));
    }

    if ($startDate > $endDate) {
        throw new InvalidArgumentException("Start date must not be after end date.");
    }

    $startDate->setTime(0, 0, 0);
    $endDate->setTime(23, 59, 59);

    return [
        'start' => $startDate,
        'end'   => $endDate,
        'start_db' => $startDate->format('Y-m-d H:i:s'),
        'end_db'   => $endDate->format('Y-m-d H:i:s'),
    ];
}