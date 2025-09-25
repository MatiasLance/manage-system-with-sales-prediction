<?php
require_once "./middleware/auth_check.php";

$pageTitle = "News - Dashboard";

$pageCss = [
    "https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap",
    "https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css",
    "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css",
    "./assets/css/dashboard.css",
    "./assets/css/modal.css",
    "./assets/css/news.css",
];

$pageJS = [
    "https://code.jquery.com/jquery-3.6.4.min.js",
    "https://cdn.jsdelivr.net/npm/chart.js",
    "./assets/js/toggleSideBar.js",
    "./assets/js/news.js",
    "./assets/js/logout.js",
];

$pageContent = __DIR__ . "/content/news-content.php";

include "./layout/layout.php";
