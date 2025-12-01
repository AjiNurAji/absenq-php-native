<?php

namespace App\Models;

use App\Core\Model;

class Course extends Model
{
  public static function all()
  {
    $stmt = self::db()->query("SELECT * FROM courses ORDER BY course_name ASC");
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  // create function
  public static function create(array $data)
  {
    $sql = "INSERT INTO courses (course_name) VALUES (:course_name)";
    $stmt = self::db()->prepare($sql);
    $stmt->execute($data);
    return $stmt->getIterator();
  }

  public static function find($id)
  {
    $stmt = self::db()->prepare("SELECT * FROM courses WHERE id = :id");
    $stmt->execute(["id" => $id]);
    return $stmt->fetch(\PDO::FETCH_OBJ);
  }

  public static function update($id, array $data)
  {
    $sql = "UPDATE courses SET course_name = :course_name WHERE id = :id";
    $stmt = self::db()->prepare($sql);
    $stmt->execute(array_merge($data, ['id' => $id]));
    return $stmt->getIterator();
  }

  public static function delete($id)
  {
    $sql = "DELETE FROM courses WHERE id = :id";
    $stmt = self::db()->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(\PDO::FETCH_OBJ);
  }

  public static function findByName($name)
  {
    $stmt = self::db()->prepare("SELECT * FROM courses WHERE course_name = :name");
    $stmt->execute(["name" => $name]);
    return $stmt->fetch(\PDO::FETCH_OBJ);
  }
}