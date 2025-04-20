<?php 
require_once __DIR__ . "/../middleware/redirect_if_login.php";

$pageTitle = "Cashier - Login";

$pageCss = ["./assets/css/login.css"];

$pageJS = ["./assets/js/cashier-login.js"];

$pageContent = __DIR__ . "/content/cashier-login-content.php";

include __DIR__ . "/../layout/layout.php";
?>