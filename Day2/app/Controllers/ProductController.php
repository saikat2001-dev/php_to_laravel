<?php

namespace App\Controllers;

use App\Models\Category;
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
  public function create()
  {
    // Fetch categories so the dropdown in the form works
    $categories = Category::getAllCategory();

    // Include the blank form
    include __DIR__ . '/../../resources/views/product/createAndUpdateProduct.php';
  }
  public function store()
  {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      header('Location: /product/create');
      exit;
    }

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
      $categories = Category::getAllCategory();
      $error = "Could not add product.";
      include __DIR__ . '/../../resources/views/product/createAndUpdateProduct.php';
    }
  }
  public function delete()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
      $id = $_POST['id'];
      $product = Product::getProductById($id);
      if ($product) {
        if (!empty($product['image'])) {
          $imagePath = 'assets/photos/' . $product['image'];
          if (file_exists($imagePath)) {
            unlink($imagePath);
          }
        }
        if (Product::deleteProductById($id)) {
          header('Location: /shop?status=delete_success');
          exit;
        }
      }
    }
    header('Location; /shop?status=delete_error');
    exit;
  }
  // This shows the form with existing values (GET)
  public function edit()
  {
    $id = $_GET['id'] ?? null;
    if (!$id) {
      header('Location: /shop');
      exit;
    }

    // Fetch product data to fill the form
    $product = Product::getProductById($id);
    // Fetch categories for the dropdown
    $categories = Category::getAllCategory();

    if (!$product) {
      header('Location: /shop?status=not_found');
      exit;
    }

    include __DIR__ . '/../../resources/views/product/createAndUpdateProduct.php';
  }

  // This handles the actual saving (POST)
  public function update()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
      $id = $_POST['id'];
      $name = $_POST['name'];
      $price = $_POST['price'];
      $description = $_POST['description'];
      $catId = $_POST['category_id'];
      $stock = $_POST['stock'];

      // Get current data to manage the image replacement
      $oldProduct = Product::getProductById($id);
      $imageName = $oldProduct['image'];

      if (!empty($_FILES['image']['name'])) {
        // If a new image is uploaded, delete the old one
        if ($imageName && file_exists("assets/photos/" . $imageName)) {
          unlink("assets/photos/" . $imageName);
        }
        $imageName = time() . '_' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "assets/photos/" . $imageName);
      }

      $success = Product::updateProduct($id, $name, $price, $catId, $description, $imageName, $stock);

      $status = $success ? 'product_update_success' : 'product_update_error';
      header("Location: /shop?status=$status");
      exit;
    }
  }
}
