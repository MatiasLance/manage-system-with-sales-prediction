<?php
session_start();

require_once __DIR__ . '/../config/db_connection.php';

header('Content-Type: application/json');

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $first_name = trim($_POST["first_name"] ?? "");
    $middle_initial = trim($_POST["middle_initial"] ?? "");
    $last_name = trim($_POST["last_name"] ?? "");
    $working_department = trim($_POST["working_department"] ?? "");
    $phone_number = trim($_POST["phone_number"]);
    $date_of_hire = $_POST["date_of_hire"];
    $job = trim($_POST["job"]);
    $educational_level = trim($_POST["educational_level"]);
    $gender = trim($_POST["gender"]);
    $date_of_birth = $_POST["date_of_birth"];
    $salary = $_POST["salary"];
}