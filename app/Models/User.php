<?php

namespace App\Models;

use App\Core\Model;

class User extends Model
{
  public static function findUsername(string $username)
  {
    $sql = "SELECT * FROM users WHERE username = :username LIMIT 1";
    $stmt = self::db()->prepare($sql);
    $stmt->execute(['username' => $username]);
    return $stmt->fetch(\PDO::FETCH_OBJ);
  }

  public static function create(array $data)
  {
    $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
    $stmt = self::db()->prepare($sql);
    return $stmt->execute($data);
  }
}