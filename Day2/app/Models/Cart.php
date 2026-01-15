<?php

namespace App\Models;

use App\Core\Database;

class Cart
{
  public static function addItem($userId, $productId, $quantity = 1)
  {
    try {
      $db = Database::getInstance();
      $stmt = $db->prepare("SELECT id from cart_items WHERE user_id = ? AND product_id = ?");
      $stmt->execute([$userId, $productId]);

      if (!$stmt->fetch()) {
        $insert = $db->prepare("INSERT INTO cart_items (user_id, product_id, quantity) VALUES (?, ?, ?)");
        $insert->execute([$userId, $productId, $quantity]);
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
    foreach ($productIds as $id => $quantity) {
      self::addItem($userId, $id, $quantity);
    }
  }
  public static function getDbCartIds($userId)
  {
    $db = Database::getInstance();
    $stmt = $db->prepare("SELECT product_id, quantity FROM cart_items WHERE user_id = ?");
    $stmt->execute([$userId]);

    return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
  }
  public static function updateQuantity($userId, $productId, $quantity)
  {
    try {
      $db = Database::getInstance();
      $stmt = $db->prepare("UPDATE cart_items SET quantity = ? WHERE user_id = ? AND product_id = ?");
      return $stmt->execute([$quantity, $userId, $productId]);
    } catch (\PDOException $pdoe) {
      error_log("Update Quantity Error: ", $pdoe->getMessage());
    }
  }
  public static function clearDBCart($userId) {
    $db = Database::getInstance();
    $stmt = $db->prepare("DELETE FROM cart_items where user_id = ?");
    return $stmt->execute([$userId]);
  }
}
