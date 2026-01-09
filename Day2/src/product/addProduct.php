<!-- addProduct.php -->
<?php
$pdo = require '../../connectDB.php';
if (!empty($_POST)) {
  $productName = trim($_POST['productName'] ?? '');
  $productCategoryId = $_POST['categoryId'] ?? 1;
  $productPrice = $_POST['productPrice'] ?? 0;

  $qry = $pdo->prepare('INSERT INTO products (name, category_id, price) VALUES (?,?,?)');
  if ($qry->execute([$productName, $productCategoryId, $productPrice])) {
    echo "Product added successfully!";
    header('Location: ../home/home.php');
    exit;
  } else {
    echo "Failed to add product.";
  }
}
