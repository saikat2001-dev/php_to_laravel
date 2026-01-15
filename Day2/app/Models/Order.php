<?php

namespace App\Models;

use App\Core\Database;

class Order
{
  public static function createOrder($userId, $total, $sessionId, $items)
  {
    try {
      $db = Database::getInstance();
      $db->beginTransaction();
      $stmt = $db->prepare("INSERT INTO orders (user_id, total_amount, stripe_session_id, status) values (?, ?, ?, 'completed')");
      $stmt->execute([$userId, $total, $sessionId]);
      $orderId = $db->lastInsertId();
      $itemStmt = $db->prepare("INSERT INTO order_items (order_id, product_id, quantity, price_at_purchase) VALUES (?, ?, ?, ?)");
      foreach($items as $item){
        $itemStmt->execute([$orderId, $item['id'], $item['qty'], $item['price']]);
        Product::reduceStock($item['id'], $item['qty']);
      }
      $db->commit();
      return $orderId;
    } catch (\PDOException $pdoe) {
      $db->rollBack();
      error_log("Create Order Error: " . $pdoe->getMessage());
    }
  }
}
