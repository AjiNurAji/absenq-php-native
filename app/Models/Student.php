<?php

namespace App\Models;

use App\Core\Model;

class Student extends Model
{
  public static function get(string $student_id)
  {
    $sql = "SELECT * FROM students WHERE student_id = :student_id LIMIT 1";
    $stmt = self::db()->prepare($sql);
    $stmt->execute(['student_id' => $student_id]);
    return $stmt->fetch(\PDO::FETCH_OBJ);
  }

  public static function all()
  {
    $stmt = self::db()->query("SELECT * FROM students ORDER BY name ASC");
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }
}