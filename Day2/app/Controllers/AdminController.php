<?php
namespace App\Controllers;

use App\Models\Order;
use App\Models\User;

class AdminController{
  public function dashboard(){
    $revenue = Order::getTotalRevenue();
    $productsSold = Order::getTotalProductsSold();
    $customerCount = User::getUsersCount();
    include __DIR__ . '/../../resources/views/admin/dashboard.php';
  }
}