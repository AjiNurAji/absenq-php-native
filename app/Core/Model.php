<?php

namespace App\Core;

use PDO;

class Model
{
  protected static ?PDO $db = null;

  public static function db(): PDO
  {
    if (!self::$db) {
      $host = Env::get('DB_HOST', 'localhost');
      $port = Env::get('DB_PORT', '3306');
      $database = Env::get('DB_DATABASE', 'database');
      $username = Env::get('DB_USERNAME', 'root');
      $password = Env::get('DB_PASSWORD', '');

      $dsn = "mysql:host=$host;port=$port;dbname=$database;charset=utf8mb4";
      $opts = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      ];

      try {
        self::$db = new PDO($dsn, $username, $password, $opts);
      } catch (\PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
      }
    }
    return self::$db;
  }
}
