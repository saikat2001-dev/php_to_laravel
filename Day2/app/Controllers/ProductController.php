<?php

namespace App\Controllers;

use App\Models\Product;

class ProductController
{
  public function index()
  {
    $products = Product::getAllProducts();
    $pageTitle = "Geschaft | Home";
    $companyName = "Geschaft";
    include __DIR__ . '/../../resources/views/home.php';
  }
}