<?php

namespace App\Models;

use App\Core\Database;

class Cart
{
  public static function addItem($userId, $productId)
  {
    try {
      $db = Database::getInstance();
      $stmt = $db->prepare("SELECT id from cart_items WHERE user_id = ? AND product_id = ?");
      $stmt->execute([$userId, $productId]);

      if (!$stmt->fetch()) {
        $insert = $db->prepare("INSERT INTO cart_items (user_id, product_id) VALUES (?, ?)");
        $insert->execute([$userId, $productId]);
      }
      return true;
    } catch (\PDOException $pdoe) {
      error_log("Add Item to Cart Error: " . $pdoe->getMessage());
      return false;
    }
  }
  public static function removeItem($userId, $productId)
  {
    try {
      $db = Database::getInstance();
      $stmt = $db->prepare("DELETE FROM cart_items WHERE user_id = ? AND product_id = ?");
      return $stmt->execute([$userId, $productId]);
    } catch (\PDOException $pdoe) {
      error_log("Remove Item from Cart Error: " . $pdoe->getMessage());
      return false;
    }
  }
  public static function syncSessionCartToDb($userId, $productIds)
  {
    foreach ($productIds as $id) {
      self::addItem($userId, $id);
    }
  }
  public static function getDbCartIds($userId)
  {
    try {
      $db = Database::getInstance();
      $stmt = $db->prepare("SELECT product_id FROM cart_items WHERE user_id = ?");
      $stmt->execute([$userId]);
      return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    } catch (\PDOException $pdoe) {
      error_log("Get DB Cart Id Error: " . $pdoe->getMessage());
    }
  }
}
