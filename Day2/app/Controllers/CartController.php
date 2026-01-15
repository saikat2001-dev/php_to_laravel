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

      if (!isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] = 1;
      }

      if (isset($_SESSION['userId'])) {
        Cart::addItem($_SESSION['userId'], $id, 1);
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
      $products = Product::getProductsByIds(array_keys($cartIds));
    }
    include __DIR__ . '/../../resources/views/cart/cart.php';
  }
  public function remove()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
      $id = $_POST['product_id'];

      if(isset($_SESSION['cart'][$id])){
        unset($_SESSION['cart'][$id]);
      }

      if (isset($_SESSION['userId'])) {
        Cart::removeItem($_SESSION['userId'], $id);
      }
    }
    header('Location: /cart');
    exit;
  }
  public function update()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'], $_POST['action'])) {
      $productId = $_POST['product_id'];
      $action = $_POST['action']; //inc or dec
      $product = Product::getProductById($productId);
      $currentQty = $_SESSION['cart'][$productId] ?? 1;

      if ($action === 'inc' && $currentQty < $product['stock']) {
        $_SESSION['cart'][$productId]++;
      } elseif ($action == 'dec' && $currentQty > 1) {
        $_SESSION['cart'][$productId]--;
      }

      if (isset($_SESSION['userId'])) {
        Cart::updateQuantity($_SESSION['userId'], $productId, $_SESSION['cart'][$productId]);
      }
      header('Location: /cart');
      exit;
    }
  }
}
