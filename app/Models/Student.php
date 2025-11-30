<?php

namespace App\Models;

use App\Core\Model;

class Student extends Model
{

  public static function create(array $data)
  {
    $sql = "INSERT INTO students (student_id, name, class_id, password) VALUES (:student_id, :name, :class_id, :password)";
    $stmt = self::db()->prepare($sql);
    $stmt->execute($data);
    return $stmt->getIterator();
  }

  public static function get(string $student_id)
  {
    // get student without password
    $sql = "SELECT * FROM students WHERE student_id = :student_id LIMIT 1";
    $stmt = self::db()->prepare($sql);
    $stmt->execute(['student_id' => $student_id]);
    return $stmt->fetch(\PDO::FETCH_OBJ);
  }

  public static function delete(string $student_id)
  {
    $sql = "DELETE FROM students WHERE student_id = :student_id";
    $stmt = self::db()->prepare($sql);
    $stmt->execute(['student_id' => $student_id]);
    return $stmt->fetch(\PDO::FETCH_OBJ);
  }

  public static function all()
  {
    $stmt = self::db()->query("SELECT student_id, name FROM students ORDER BY name ASC");
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  public static function update(string $id, array $data)
  {

    // if password empty and same
    if (empty($data["password"]) || $data["password"] == null || password_verify($data["password"], self::get($id)->password)) {
      unset($data["password"]);
    }

    // if password not empty
    if (!empty($data["password"])) {
      $data["password"] = password_hash($data["password"], PASSWORD_DEFAULT);

      $sql = "UPDATE students SET name = :name, class_id = :class_id, password = :password WHERE student_id = :student_id";
      $stmt = self::db()->prepare($sql);
      $stmt->execute(array_merge($data, ['student_id' => $id]));
    }

    // if password empty
    else {
      $sql = "UPDATE students SET name = :name, class_id = :class_id WHERE student_id = :student_id";
      $stmt = self::db()->prepare($sql);
      $stmt->execute(array_merge($data, ['student_id' => $id]));
    }

  }

  public static function getWithClass()
  {
    // get students with class name and hiiden password
    $sql = "SELECT s.student_id, s.name, c.class_name as class_name 
            FROM students s 
            JOIN class c ON s.class_id = c.id 
            ORDER BY s.name ASC";
    $stmt = self::db()->query($sql);
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  public static function getWithFilterClass(int $class_id)
  {
    // get students with class name and hiiden password
    $sql = "SELECT s.student_id, s.name, c.class_name as class_name 
            FROM students s 
            JOIN class c ON s.class_id = c.id 
            WHERE c.id = $class_id
            ORDER BY s.name ASC";
    $stmt = self::db()->query($sql);
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  public static function getCount()
  {
    $stmt = self::db()->query("SELECT COUNT(*) as count FROM students");
    $result = $stmt->fetch(\PDO::FETCH_OBJ);
    return $result->count;
  }
}