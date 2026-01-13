<?php
// bulkDeleteProduct.php
require '../../connectDB.php';

session_start();
if($_POST['action'] === 'bulk_delete'){
  if(is_array($_POST['ids'])){
    $ids = $_POST['ids'];
    $placeholders = implode(',', array_fill(0, count($ids), '?'));

    $bulkDeleteQuery = $pdo->prepare("DELETE FROM products WHERE id IN ($placeholders)");

    if($bulkDeleteQuery->execute($ids)){
      $_SESSION['msg'] = "Items deleted successfully";
      $_SESSION['msg_type'] = "success";
      header("Location: ../home/home.php");
      exit;
    }
  }
}