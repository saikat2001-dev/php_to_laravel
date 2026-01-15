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
  public static function getProductsByIds($ids) {
    try {
      if(empty($ids)) return [];

      $db = Database::getInstance();
      $placeholder = implode(',', array_fill(0, count($ids), '?'));
      $stmt = $db->prepare("SELECT * FROM products WHERE id IN ($placeholder)");
      $stmt->execute($ids);
      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    } catch (\PDOException $pdoe) {
      error_log("Get Products By Ids Error: ".$pdoe->getMessage());
      return [];
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
  public static function getProductById($id)
  {
    try {
      $db = Database::getInstance();
      $stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
      $stmt->execute([$id]);
      return $stmt->fetch(\PDO::FETCH_ASSOC);
    } catch (\PDOException $pdoe) {
      error_log("Get Product Error: " . $pdoe->getMessage());
      return false;
    }
  }
  public static function deleteProductById($id)
  {
    try {
      $db = Database::getInstance();
      $stmt = $db->prepare("DELETE FROM products WHERE id = ?");
      return $stmt->execute([$id]);
    } catch (\PDOException $pdoe) {
      error_log("Delete Product Error: " . $pdoe->getMessage());
      return false;
    }
  }
  public static function updateProduct($id, $name, $price, $catId, $description, $imageName){
    try {
      $db = Database::getInstance();
      $sql = "UPDATE products
              SET name = ?, price = ?, category_id = ?, description = ?, image = ?
              WHERE id = ?";
      $stmt = $db->prepare($sql);
      return $stmt->execute([$name, $price, $catId, $description, $imageName, $id]);
    } catch (\PDOException $pdoe) {
      error_log("Update Product Error: ".$pdoe->getMessage());
    }
  }
}
