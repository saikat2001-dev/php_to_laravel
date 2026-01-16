<?php
namespace App\Controllers;

use App\Models\Order;
use App\Models\User;

class AdminController{
  public function dashboard(){
    if(!isset($_SESSION['userId'])) {
      header('Location: /login');
      exit;
    }
    $revenue = Order::getTotalRevenue();
    $productsSold = Order::getTotalProductsSold();
    $customerCount = User::getUsersCount();
    $topBuyers = Order::getTopBuyers(5);
    $filter = $_GET['status'] ?? "all";
    $recentOrders = Order::getFilteredOrders($filter);
    include __DIR__ . '/../../resources/views/admin/dashboard.php';
  }
}