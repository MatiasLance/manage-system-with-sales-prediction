<?php
session_start();

if (!isset($_SESSION['id']) && !isset($_SESSION['cashier_id'])) {
    header('Location: /');
    exit();
}