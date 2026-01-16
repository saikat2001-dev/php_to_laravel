<!-- Geschäft -->
<?php
session_start();
use App\Controllers\OrderController;
use App\Controllers\StripeController;
use App\Controllers\CartController;

require_once __DIR__ . '/../vendor/autoload.php';

define('COMPANY_NAME', "Geschaft");

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

use App\Controllers\ProductController;
use App\Controllers\UserController;

$route = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($route) {
  case '/':
    (new ProductController())->index();
    break;
  case '/login':
    (new UserController())->login();
    break;
  case '/register':
    (new UserController())->register();
    break;
  case '/cart':
    (new CartController())->index();
    break;
  case '/shop':
    (new ProductController())->shop();
    break;
  case '/product/create':
    // If POST, store it. If GET, show the blank form.
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      (new ProductController())->store(); // controller to save to DB (POST request)
    } else {
      (new ProductController())->create(); // controller to open webview (GET request)
    }
    break;
  case '/product/delete':
    (new ProductController())->delete();
    break;
  case '/product/update':
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      (new ProductController())->update(); //controller to save to DB (POST request)
    } else {
      (new ProductController())->edit(); // controller to open webview (GET request)
    }
    break;
  case '/cart/add':
    (new CartController())->add();
    break;
  case '/cart/update-quantity':
    (new CartController())->update();
    break;
  case '/cart/remove':
    (new CartController())->remove();
    break;
  case '/checkout/create-session':
    (new StripeController())->createSession();
    break;
  case '/checkout/success':
    (new StripeController())->success();
    break;
  case '/my-orders':
    (new OrderController())->index();
    break;
  case '/logout':
    (new UserController())->logout();
    break;
  default:
    http_response_code(404);
    $display_title = COMPANY_NAME . " | Page Not Found";
    include __DIR__ . '/../resources/views/error/404.php';
    break;
}
