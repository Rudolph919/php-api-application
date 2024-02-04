<?php

namespace App\Config;

use PDO;
use PDOException;

class DatabaseConnection
{
  private static $host = 'mysql-db';
  private static $db_name = 'subscribers';
  private static $username = 'test_user';
  private static $password = 'test_password';
  private static $conn;

  public static function createConnection()
  {
    try {
      $dsn = 'mysql:host=' . self::$host . ';dbname=' . self::$db_name;
      self::$conn = new PDO($dsn, self::$username, self::$password);
      self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      die('Connection failed: ' . $e->getMessage());
    }

    return self::$conn;
  }
}
