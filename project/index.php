<?php
$request = $_SERVER['REQUEST_URI'];
$viewDir = '/views/';

switch($request) {
  case '/':
    require __DIR__ . $viewDir . 'cashier-login.php';
    break;
  case '/pos':
    require __DIR__ . $viewDir . 'pos.php';
    break;
  case '/admin':
    require __DIR__ . $viewDir . 'login.php';
    break;
  case '/register':
    require __DIR__ . $viewDir . 'register.php';
    break;
  case '/dashboard':
    require __DIR__ . $viewDir . 'dashboard.php';
    break;
  case '/bookings':
    require __DIR__ . $viewDir . 'bookings.php';
    break;
  case '/employees':
    require __DIR__ . $viewDir . 'employee.php';
    break;
  case '/products':
    require __DIR__ . $viewDir . 'products.php';
    break;
  case '/sales':
    require __DIR__ . $viewDir . 'sales.php';
    break;
  case '/inventory':
    require __DIR__ . $viewDir . 'inventory.php';
    break;
  default:
    http_response_code(404);
    require __DIR__ . $viewDir . '404.php';
}