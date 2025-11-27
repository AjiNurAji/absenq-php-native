<?php

namespace App\Models;

use App\Core\Model;

class Schedule extends Model
{
  public static function create(array $data)
  {
    $sql = "INSERT INTO schedules (course, class, date, start_time, end_time, room) 
            VALUES (:course, :class, :date, :start_time, :end_time, :room)";
    
    $stmt = self::db()->prepare($sql);
    return $stmt->execute($data);
  }

  public static function get(string $id)
  {
    $sql = "SELECT * FROM schedules WHERE id = :id LIMIT 1";
    $stmt = self::db()->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(\PDO::FETCH_OBJ);
  }

  public static function all()
  {
    $stmt = self::db()->query("SELECT * FROM schedules ORDER BY date ASC, date ASC");
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }
}