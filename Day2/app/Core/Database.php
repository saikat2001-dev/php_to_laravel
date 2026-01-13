<?php

namespace App\Core;

use PDO;
use PDOException;

class Database
{
  private static $instance = null;
  private $connection;

  private function __construct()
  {
    $config = require __DIR__ . '/../../config/db.php';

    $dsn = "mysql:host={$config['host']};dbname={$config['database']};charset={$config['charset']}";

    try {
      $this->connection = new PDO(
        $dsn,
        $config['username'],
        $config['password'],
        $config['options']
      );
    } catch (PDOException $pdoe) {
      error_log("Database Connection Error: " . $pdoe->getMessage());
    }
  }

  public static function getInstance()
  {
    if (self::$instance === null) {
      $object = new self();
      self::$instance = $object->connection;
    }
    if (self::$instance === null) {
      throw new \Exception("Database connection could not be established.");
    }
    return self::$instance;
  }

  // Prevent cloning of the instance (Singleton best practice)
  private function __clone()
  {
  }

  // Prevent unserializing of the instance (Singleton best practice)
  public function __wakeup()
  {
    throw new \Exception("Cannot unserialize a singleton.");
  }
}