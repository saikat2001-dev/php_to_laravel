<!-- Geschäft -->
<?php
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

use App\Controllers\ProductController;

$route = $_GET['route'] ?? '/';
if ($route === '/') {
  $controller = new ProductController();
  $controller->index();
}