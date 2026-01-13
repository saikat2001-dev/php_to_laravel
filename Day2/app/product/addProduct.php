<?php
// addProduct.php
session_start();
$pdo = require '../../connectDB.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // 1. Collect and clean data
  $productName = trim($_POST['productName'] ?? '');
  $productCategoryId = $_POST['categoryId'] ?? '';
  $productPrice = $_POST['productPrice'] ?? '';

  // 2. Validation: Check if any fields are empty
  if (empty($productName) || empty($productCategoryId) || $productPrice === '') {
    $_SESSION['msg'] = "Error: All fields are required.";
    $_SESSION['msg_type'] = "error";
    header('Location: ../home/home.php');
    exit;
  }

  // 3. Database Attempt
  try {
    $qry = $pdo->prepare('INSERT INTO products (name, category_id, price) VALUES (?, ?, ?)');
    if ($qry->execute([$productName, $productCategoryId, $productPrice])) {
      $_SESSION['msg'] = "Product '$productName' added successfully!";
      $_SESSION['msg_type'] = "success";
    } else {
      $_SESSION['msg'] = "Error: Could not save to database.";
      $_SESSION['msg_type'] = "error";
    }
  } catch (PDOException $e) {
    $_SESSION['msg'] = "Database Error: " . $e->getMessage();
    $_SESSION['msg_type'] = "error";
  }

  // 4. Always redirect back to home.php
  header('Location: ../home/home.php');
  exit;
}