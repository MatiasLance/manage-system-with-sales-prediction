<?php
session_start();

if (isset($_SESSION['id'])) {
    header("Location: /dashboard");
    exit();
}

if (isset($_SESSION['cashier_id'])) {
    header("Location: /pos");
    exit();
}