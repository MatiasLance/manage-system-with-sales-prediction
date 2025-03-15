<?php
session_start();
header("Content-Type: application/json");

require_once __DIR__ . '/../../config/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        echo json_encode(["error" => "Invalid ID"]);
        exit;
    }

    $id = intval($_GET['id']); // Ensure ID is an integer for security

    // Prepare the SQL query
    $stmt = $conn->prepare("SELECT quantity, product_name, barcode_image, date_expiration, date_produce, price, unit_of_price FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);

    // Execute query
    if ($stmt->execute()) {
        // Bind result variables
        $stmt->bind_result($quantity, $product_name, $barcode_image, $date_expiration, $date_produce, $price, $unit_of_price);

        // Fetch the result
        if ($stmt->fetch()) {
            echo json_encode([
                "quantity"       => $quantity,
                "product_name"   => $product_name,
                "barcode_image"  => $barcode_image,
                "date_expiration"=> $date_expiration,
                "date_produce"   => $date_produce,
                "price"          => $price,
                "unit_of_price"  => $unit_of_price
            ]);
        } else {
            echo json_encode(["error" => true, "message" => "No data found"]);
        }
    } else {
        echo json_encode(["error" => true, "message" => "Query execution failed"]);
    }

    // Close connections
    $stmt->close();
    $conn->close();
}
?>
