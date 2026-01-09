<?php
session_start();
$pdo = require '../../connectDB.php';

if($_SERVER['REQUEST_METHOD'] === 'GET'){
  $productId = $_GET['id'];
  $deleteQry = $pdo->prepare('DELETE FROM products WHERE id = ?');
  if($deleteQry->execute([$productId])) {
    $_SESSION['msg'] = "Product deleted successfully";
    $_SESSION['msg_type'] = "success";
  }
  else {
    $_SESSION['msg'] = "Failed to delete product";
    $_SESSION['msg_type'] = "error";
  }
  header('Location: ../home/home.php');
  exit;
}