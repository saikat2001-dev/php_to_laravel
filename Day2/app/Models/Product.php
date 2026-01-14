<?php

namespace App\Models;

use App\Core\Database;

class Product
{
  public static function getAllProducts($limit = null)
  {
    try {
      $db = Database::getInstance();
      $qry = "SELECT * FROM products";
      if ($limit) {
        $qry .= ' LIMIT ' . (int) $limit;
      }
      $stmt = $db->query($qry);
      $res = $stmt->fetchAll(\PDO::FETCH_ASSOC);
      if (count($res) === 0) {
        error_log("Query successful, but the 'products' table is empty.");
      }
      return $res;
    } catch (\PDOException $pdoe) {
      error_log("Get All Product Error: " . $pdoe->getMessage());
    }
  }

  public static function addProduct($productName, $productPrice, $categoryId, $description, $imageName)
  {
    try {
      $db = Database::getInstance();
      $stmt = $db->prepare("INSERT INTO products (name, price, category_id, description, image) VALUES (?, ?, ?, ?, ?)");
      $res = $stmt->execute([$productName, $productPrice, $categoryId, $description, $imageName]);
      return $res ? $db->lastInsertId() : false;
    } catch (\PDOException $pdoe) {
      error_log("Add Product Error: " . $pdoe->getMessage());
      return false;
    }
  }
}