<!-- Geschäft -->
<?php
session_start();

require_once __DIR__ . '/../vendor/autoload.php';

define('COMPANY_NAME', "Geschaft");

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

use App\Controllers\ProductController;
use App\Controllers\UserController;

$route = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($route) {
  case '/':
    (new ProductController())->getAllProducts();
    break;
  case '/login':
    (new UserController())->login();
    break;
  case '/register':
    (new UserController())->register();
    break;
  default:
    http_response_code(404);
    $display_title = COMPANY_NAME . " | Page Not Found";
    include __DIR__ . '/../resources/views/error/404.php';
    break;
}