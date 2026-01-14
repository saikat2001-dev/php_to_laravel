<?php

namespace App\Controllers;

use App\Models\Product;

class ProductController
{
  public function index()
  {
    $products = Product::getAllProducts(4);
    // $pageTitle = "Geschaft | Home";
    include __DIR__ . '/../../resources/views/home.php';
  }
  public function shop()
  {
    $products = Product::getAllProducts();
    include __DIR__ . '/../../resources/views/shop/shop.php';
  }
  public function store()
  {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $catId = $_POST['category_id'] ?? 1;

    $imageName = null;
    if (!empty($_FILES['image']['name'])) {
      $imageName = time() . '_' . $_FILES['image']['name'];
      move_uploaded_file($_FILES['image']['tmp_name'], "assets/photos/" . $imageName);
    }
    $success = Product::addProduct($name, $price, $catId, $description, $imageName);
  
    if ($success) {
        header('Location: /shop?success=product_added');
    } else {
        // Handle error
        $error = "Could not add product.";
        include __DIR__ . '/../../resources/views/product/create/createProduct.php';
    }
  }
}