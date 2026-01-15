<?php

namespace App\Controllers;

use App\Models\Cart;
use App\Models\Product;

class CartController
{
  public function add()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
      $id = $_POST['product_id'];

      if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
      }

      if (!in_array($id, $_SESSION['cart'])) {
        $_SESSION['cart'][] = $id;
      }

      if(isset($_SESSION['userId'])) {
        Cart::addItem($_SESSION['userId'], $id);
      }

      header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/shop'));
      exit;
    }
  }
  public function index()
  {
    $cartIds = $_SESSION['cart'] ?? [];
    $products = [];
    if (!empty($cartIds)) {
      $products = Product::getProductsByIds($cartIds);
    }
    include __DIR__ . '/../../resources/views/cart/cart.php';
  }
  public function remove()
  {
    if ($_SERVER['REQUEST_METHOD']=== 'POST' && isset($_POST['product_id'])) {
      $id = $_POST['product_id'];

      if (($key = array_search($id, $_SESSION['cart'])) !== false) {
        unset($_SESSION['cart'][$key]);
      }

      if(isset($_SESSION['userId'])) {
        Cart::removeItem($_SESSION['userId'], $id);
      }

      header('Location: /cart');
      exit;
    }
  }
}
