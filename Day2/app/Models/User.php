<?php

namespace App\Models;

use App\Core\Database;
class User
{
  public function getAllUsers()
  {
    $db = Database::getInstance();
    $stmt = $db->query("SELECT * FROM users");
    return $stmt->fetchAll();
  }
}