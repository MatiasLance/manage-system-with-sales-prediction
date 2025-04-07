<?php
session_start();
header("Content-Type: application/json");

require_once __DIR__ . '/../../config/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        echo json_encode(["error" => "Invalid ID"]);
        exit;
    }

    $id = intval($_GET['id']); // Ensure ID is an integer

    // Prepare the SQL query with JOIN
    $sql = "SELECT 
                p.quantity,
                pn.id as productNameID,
                pn.product_name, 
                pn.product_code,
                p.date_expiration, 
                p.date_produce, 
                p.price, 
                p.unit_of_price, 
                p.category, 
                p.status
            FROM products p
            INNER JOIN products_name pn ON p.product_name_id = pn.id
            WHERE p.id = ?";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(["error" => true, "message" => "Database error: " . $conn->error]);
        exit;
    }

    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();

        if ($product) {
            echo json_encode([
                "success" => true,
                "product" => $product
            ], JSON_NUMERIC_CHECK);
        } else {
            echo json_encode(["error" => true, "message" => "No product found with that ID"]);
        }
    } else {
        echo json_encode(["error" => true, "message" => "Query execution failed"]);
    }

    $stmt->close();
    $conn->close();
}
?>
