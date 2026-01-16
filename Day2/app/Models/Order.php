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
      foreach ($items as $item) {
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
  public static function getOrdersByUser($userId)
  {
    $db = Database::getInstance();
    $stmt = $db->prepare("
    SELECT o.id, o.total_amount, o.status, o.created_at, oi.quantity, oi.price_at_purchase, p.name as product_name
    FROM orders o
    JOIN order_items oi ON o.id = oi.order_id
    JOIN products p ON oi.product_id = p.id
    WHERE o.user_id = ?
    ORDER BY o.created_at DESC
    ");
    $stmt->execute([$userId]);
    $results = $stmt->fetchAll();
    $orders = [];
    foreach ($results as $row) {
      $orders[$row['id']]['into'] = [
        'total' => $row['total_amount'],
        'status' => $row['status'],
        'date' => $row['created_at'],
      ];
      $orders[$row['id']]['items'][] = $row;
    }
    return $orders;
  }
}
