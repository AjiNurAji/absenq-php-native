<?php

namespace App\Models;

use App\Core\Model;

class Classes extends Model
{
  public static function all()
  {
    $stmt = self::db()->query("SELECT * FROM class ORDER BY class_name ASC");
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }
}