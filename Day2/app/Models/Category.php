<?php

namespace App\Models;

use App\Core\Database;

class Category
{
  public static function getAllCategory()
  {
    try {
      $db = Database::getInstance();
      $res = $db->query("SELECT * FROM category");
      if (!$res) {
        error_log("Query successful, but 'category' is empty");
      }
      return $res;
    } catch (\PDOException $pdoe) {
      error_log("Category Fetch Error: " . $pdoe->getMessage());
    }
  }
  public static function createCategory($categoryName)
  {
    try {
      $db = Database::getInstance();
      $stmt = $db->prepare("INSERT INTO categories (name) VALUES (?)");
      $res = $stmt->execute([$categoryName]);

      return $res ? $db->lastInsertId() : false;
    } catch (\PDOException $pdoe) {
      error_log("Create Category Error: " . $pdoe->getMessage());
      return false;
    }
  }
}
