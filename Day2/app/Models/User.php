<?php

namespace App\Models;

use App\Core\Database;
class User
{
  public static function getAllUsers()
  {
    $db = Database::getInstance();
    $stmt = $db->query("SELECT * FROM users");
    return $stmt->fetchAll();
  }
  public static function registerUser($name, $email, $password, $roleId)
  {
    $db = Database::getInstance();
    try {
      $db->beginTransaction();

      $stmt = $db->prepare("INSERT INTO users (name, email, password) VALUES(?, ?, ?)");
      $stmt->execute([$name, $email, $password]);
      $userId = $db->lastInsertId();

      $stmtRole = $db->prepare("INSERT INTO user_roles (user_id, role_id) VALUES (?, ?)");
      $stmtRole->execute([$userId, $roleId]);

      $db->commit();
      return true;
    } catch (\PDOException $pdoe) {
      $db->rollBack();
      error_log("Register User Error: " . $pdoe->getMessage());
      return false;
    }
  }
  public static function loginUser($email, $password)
  {
    try {
      $db = Database::getInstance();
      $stmt = $db->prepare("SELECT u.*, ur.role_id 
                FROM users u 
                LEFT JOIN user_roles ur ON u.id = ur.user_id 
                WHERE u.email = ?");
      $stmt->execute([$email]);

      $user = $stmt->fetch(\PDO::FETCH_ASSOC);

      if ($user && $password === $user['password']) {
        $sql = "SELECT DISTINCT p.slug FROM permissions p
        JOIN role_perm rp ON p.id = rp.perm_id
        JOIN user_roles ur ON rp.role_id = ur.role_id
        WHERE ur.user_id = ?";
        $permStmt = $db->prepare($sql);
        $permStmt->execute([$user['id']]);
        $permissions = $permStmt->fetchAll(\PDO::FETCH_COLUMN);
        return [
          'id' => $user['id'],
          'name' => $user['name'],
          'email' => $user['email'],
          'roleId' => $user['role_id'],
          'permissions' => $permissions
        ];
      }
      return false;
    } catch (\PDOException $pdoe) {
      error_log("Login User Error: " . $pdoe->getMessage());
      return false;
    }
  }
  public static function getUsersCount(){
    $db = Database::getInstance();
    $res = $db->query("SELECT count(*) from users");
    return $res->fetchColumn();
  }
}