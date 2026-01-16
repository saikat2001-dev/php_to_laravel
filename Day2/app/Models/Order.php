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
      $orders[$row['id']]['info'] = [
        'total' => $row['total_amount'],
        'status' => $row['status'],
        'date' => $row['created_at'],
      ];
      $orders[$row['id']]['items'][] = $row;
    }
    return $orders;
  }
  public static function getTotalRevenue(){
    $db = Database::getInstance();
    $res = $db->query("SELECT sum(total_amount)  FROM orders");
    return $res->fetchColumn();
  }
  public static function getTotalProductsSold() {
    $db = Database::getInstance();
    $res = $db->query("SELECT sum(quantity) FROM order_items");
    return $res->fetchColumn();
  }
  public static function getTopBuyers($limit){
    $db = Database::getInstance();
    $stmt = $db->prepare("
      SELECT u.name, count(o.id) as order_count, sum(o.total_amount) as total_spent
      FROM orders o
      JOIN users u ON o.user_id = u.id
      WHERE o.status = 'completed'
      GROUP BY o.user_id
      ORDER BY total_spent DESC
      LIMIT ?
    ");
    $stmt->execute([$limit]);
    return $stmt->fetchAll();
  }
  public static function getFilteredOrders($status = 'all'){
    $db = Database::getInstance();
    $sql = "SELECT o.*, u.name as customer_name
      FROM orders o
      LEFT JOIN users u ON o.user_id = u.id";
    
    $params = [];

    if($status !== 'all'){
      $sql .= " WHERE o.status = ?";
      $params[] = $status;
    }

    $sql .= " ORDER BY o.created_at DESC";
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
  }
}
