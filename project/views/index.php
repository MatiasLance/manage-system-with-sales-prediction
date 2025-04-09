<?php 

$pageTitle = "RMC - Goat Farm Website";

$pageCss = ["./assets/css/index.css"];

$pageJS = [
    "./assets/js/product.js",
    "./assets/js/index.js"
];

$pageContent = __DIR__ . "/content/index-content.php";

include __DIR__ . "/../layout/layout.php";
?>