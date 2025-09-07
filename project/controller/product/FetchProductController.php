<?php
session_start();
header("Content-Type: application/json");

require_once __DIR__ . '/../../config/db_connection.php';

$items_per_page = 10;
$search = trim($_GET['search'] ?? '');
$page = (int)($_GET['page'] ?? 1);
if ($page < 1) $page = 1;
$offset = ($page - 1) * $items_per_page;

$search_param = "%$search%";

$whereClause = "WHERE (pn.product_name LIKE ? OR pn.product_code LIKE ?)";
$params = [$search_param, $search_param];
$types = "ss";

$stmt = $conn->prepare("
    SELECT p.*, pn.product_name, pn.product_code, pn.product_category
    FROM products p
    INNER JOIN products_name pn ON p.product_name_id = pn.id
    $whereClause
    ORDER BY pn.product_category, pn.product_name
    LIMIT ? OFFSET ?
");

$types .= "ii";
$params[] = $items_per_page;
$params[] = $offset;

$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$stmt_total = $conn->prepare("
    SELECT COUNT(*) AS total
    FROM products p
    INNER JOIN products_name pn ON p.product_name_id = pn.id
    $whereClause
");
$stmt_total->bind_param("ss", $search_param, $search_param);
$stmt_total->execute();
$total_result = $stmt_total->get_result();
$total_row = $total_result->fetch_assoc();
$total_items = (int)($total_row['total']);
$total_pages = $total_items > 0 ? ceil($total_items / $items_per_page) : 1;
$stmt_total->close();

function getCategoryPages($conn, $category, $search = '', $items_per_page = 10) {
    $searchParam = "%$search%";
    $sql = "SELECT COUNT(*) AS total
            FROM products p
            INNER JOIN products_name pn ON p.product_name_id = pn.id
            WHERE pn.product_category = ?
              AND (pn.product_name LIKE ? OR pn.product_code LIKE ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $category, $searchParam, $searchParam);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $total = (int)($row['total']);
    $stmt->close();

    return [
        'total_items' => $total,
        'total_pages' => $total > 0 ? ceil($total / $items_per_page) : 1
    ];
}

$dairy = getCategoryPages($conn, 'dairy', $search, $items_per_page);
$grains = getCategoryPages($conn, 'grains and cereals', $search, $items_per_page);

$response = [
    'success' => true,
    'data' => $data,
    'pagination' => [
        'current_page' => $page,
        'items_per_page' => $items_per_page,
        'total_items' => $total_items,
        'total_pages' => $total_pages,
        'has_next' => $page < $total_pages,
        'has_prev' => $page > 1
    ],
    'categories' => [
        'dairy' => [
            'total_items' => $dairy['total_items'],
            'total_pages' => $dairy['total_pages']
        ],
        'grains_cereals' => [
            'total_items' => $grains['total_items'],
            'total_pages' => $grains['total_pages']
        ]
    ],
    'search' => $search
];

echo json_encode($response, JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK);

$conn->close();