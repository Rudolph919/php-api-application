<?php

namespace App\Config;

use mysqli;

class Database
{
  private static $host = 'mysql-db';
    private static $db_name = 'subscribers';
    private static $username = 'test_user';
    private static $password = 'test_password';
    private static $conn;

    public static function getConnection()
    {
        self::$conn = new mysqli(self::$host, self::$username, self::$password, self::$db_name);

        if (self::$conn->connect_error) {
            die('Connection failed: ' . self::$conn->connect_error);
        }

        return self::$conn;
    }
}
