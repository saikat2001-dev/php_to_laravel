<?php

namespace App\Controllers;

use App\Models\Order;

class OrderController
{
    public function index()
    {
        if(!isset($_SESSION['userId'])) {
            header('Location: /login');
            exit;
        }
        $userId = $_SESSION['userId'];
        $orders = Order::getOrdersByUser($userId);

        include __DIR__ . '/../../resources/views/order/my_order.php';
    }
}
