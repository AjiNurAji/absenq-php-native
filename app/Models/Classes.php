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

  public static function find(int $id)
  {
    $stmt = self::db()->prepare("SELECT * FROM class WHERE id = :id");
    $stmt->execute(["id" => $id]);
    return $stmt->fetch(\PDO::FETCH_OBJ);
  }

  public static function create(array $data)
  {
    $stmt = self::db()->prepare("INSERT INTO class (class_name) VALUES (:class_name)");
    $stmt->execute(["class_name" => $data["name"]]);
  }

  public static function delete(int $id)
  {
    $stmt = self::db()->prepare("DELETE FROM class WHERE id = :id");
    $stmt->execute(["id" => $id]);
  }

  public static function update(int $id, array $data)
  {
    $stmt = self::db()->prepare("UPDATE class SET class_name = :class_name WHERE id = :id");
    $stmt->execute(array_merge(["class_name" => $data["name"]], ["id" => $id]));
  }

  public static function findByName(string $name)
  {
    $stmt = self::db()->prepare("SELECT * FROM class WHERE class_name = :name");
    $stmt->execute(["name" => $name]);
    return $stmt->fetch(\PDO::FETCH_OBJ);
  }
}