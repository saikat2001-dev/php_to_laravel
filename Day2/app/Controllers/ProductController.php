<?php

namespace App\Controllers;

use App\Models\Product;

class ProductController
{
  public function getAllProducts()
  {
    $products = Product::getAllProducts();
    $pageTitle = "Geschaft | Home";
    include __DIR__ . '/../../resources/views/home.php';
  }
}