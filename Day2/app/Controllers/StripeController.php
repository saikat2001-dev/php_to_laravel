<?php
namespace App\Controllers;

use App\Core\Email;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class StripeController {
  private $secretKey;
  public function __construct(){
    $config = require __DIR__ . '/../../config/stripe.php';
    $this->secretKey = $config['secret_key'];
    Stripe::setApiKey($this->secretKey);
  }
  public function createSession(){
    $cartData = $_SESSION['cart'] ?? [];
    if(empty($cartData)){
      header('Location: /cart');
      exit;
    }
    //check if loggedin
    if(!isset($_SESSION['userId'])){
      header('Location: /login?redirect_to=checkout/create-session');
      exit;
    }

    $products = Product::getProductsByIds(array_keys($cartData));
    $lineItems = [];

    foreach($products as $product) {
      $qty = $cartData[$product['id']];
      $lineItems[] = [
        'price_data' => [
          'currency' => 'inr',
          'product_data' => [
            'name' => $product['name'],
          ],
          'unit_amount' => $product['price'] * 100,
        ],
        'quantity' => $qty,
      ];
    }
    $session = Session::create([
      'payment_method_types' => ['card'],
      'line_items' => $lineItems,
      'mode' => 'payment',
      'success_url' => 'http://localhost:4000/checkout/success?session_id={CHECKOUT_SESSION_ID}',
      'cancel_url' => 'http://localhost:4000/cart',
    ]);

    header('Location: ' . $session->url);
    exit;
  }
  public function success(){
    $sessionId = $_GET['session_id'] ?? null;
    if(!$sessionId) {
      header('Location: /');
      exit;
    }

    try {
      $session = Session::retrieve($sessionId);

      if($session->payment_status === 'paid'){
        $cartData = $_SESSION['cart'];
        $products = Product::getProductsByIds(array_keys($cartData));

        $orderItems = [];
        $total = 0;
        foreach($products as $product) {
          $qty = (int)$cartData[$product['id']];
          $orderItems[] = [
            'id' => $product['id'],
            'qty' => $qty,
            'price' => $product['price']
          ];
          $total += (int)($product['price'] * $qty);
        }

        $userId = $_SESSION['userId'] ?? null;
        $orderId = Order::createOrder($userId, $total, $sessionId, $orderItems);
        unset($_SESSION['cart']);
        if($orderId) {
          $userEmail = $session->customer_details->email;
          Email::sendOrderConfirmation($userEmail, $orderId, $total);
          Cart::clearDBCart($userId);
        }

        include __DIR__ . '/../../resources/views/checkout/success.php';
      }
    } catch (\Exception $e) {
      echo "Checkout Error: ". $e->getMessage();
    }
  }
}