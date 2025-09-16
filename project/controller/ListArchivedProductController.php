<?php
session_start();
header("Content-Type: application/json");

require_once __DIR__ . '/../config/db_connection.php';

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$items_per_page = 10;
$search = isset($_GET['search']) ? $_GET['search'] : "";

$offset = ($page - 1) * $items_per_page;
$search_param = "%$search%";

$sql = "
    SELECT 
        ap.*, 
        pn.product_name,
        pn.product_code
    FROM archived_products ap
    JOIN products_name pn ON ap.product_name_id = pn.id
    WHERE pn.product_name LIKE ?
    ORDER BY ap.deleted_at DESC
    LIMIT ? OFFSET ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sii", $search_param, $items_per_page, $offset);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$sql_total = "
    SELECT COUNT(*) AS total 
    FROM archived_products ap
    JOIN products_name pn ON ap.product_name_id = pn.id
    WHERE pn.product_name LIKE ?
";
$stmt_total = $conn->prepare($sql_total);
$stmt_total->bind_param("s", $search_param);
$stmt_total->execute();
$total_result = $stmt_total->get_result();
$total_row = $total_result->fetch_assoc();
$total_items = $total_row['total'];
$stmt_total->close();

$total_pages = ceil($total_items / $items_per_page);

$response = [
    'data' => $data,
    'total_pages' => $total_pages,
    'total_archived_products' => $total_items
];

echo json_encode($response, JSON_NUMERIC_CHECK);
$conn->close();
?>
