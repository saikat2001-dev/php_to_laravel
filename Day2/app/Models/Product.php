<?php

namespace App\Models;

use App\Core\Database;

class Product
{
  public static function getAllProducts()
  {
    try {
      $db = Database::getInstance();
      $stmt = $db->query("SELECT * FROM products");
      $res = $stmt->fetchAll();
      if (count($res) === 0) {
        error_log("Query successful, but the 'products' table is empty.");
      }
      return $res;
    } catch (\PDOException $pdoe) {
      error_log("Get All Product Error: " . $pdoe->getMessage());
    }
  }

  public static function addProduct($productName, $productPrice, $categoryId)
  {
    try {
      $db = Database::getInstance();
      $stmt = $db->prepare("INSERT INTO products (name, price, category_id) VALUES (?,?,?)");
      $res = $stmt->execute([$productName, $productPrice, $categoryId]);
      return $res ? $db->lastInsertId() : false;
    } catch (\PDOException $pdoe) {
      error_log("Add Product Error: " . $pdoe->getMessage());
    }
  }
}