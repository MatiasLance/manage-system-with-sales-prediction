<?php
require_once "./middleware/auth_check.php";

$pageTitle = "Point of Sale - MBRLCFI";

$pageCss = ["./assets/css/pos.css"];

$pageJS = [
    "./assets/js/product.js",
    "./assets/js/pos.js",
    "./assets/js/logout.js",
    "./assets/js/barcodeScanner.js",
];

$pageContent = __DIR__ . "/content/pos-content.php";

include __DIR__ . "/../layout/layout.php";
?>