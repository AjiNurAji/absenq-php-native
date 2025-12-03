<?php

namespace App\Models;

use App\Core\Model;

class Schedule extends Model
{
  public static function create(array $data)
  {
    $sql = "INSERT INTO schedules (course_id, class_id, date, start_time, end_time) 
            VALUES (:course_id, :class_id, :date, :start_time, :end_time)";

    $stmt = self::db()->prepare($sql);
    return $stmt->execute($data);
  }

  public static function delete($id)
  {
    $sql = "DELETE FROM schedules WHERE id = :id";
    $stmt = self::db()->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(\PDO::FETCH_OBJ);
  }

  public static function getById($id)
  {
    $sql = "SELECT * FROM schedules WHERE id = :id";
    $stmt = self::db()->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(\PDO::FETCH_OBJ);
  }

  public static function update(string $id, array $data)
  {
    $sql = "UPDATE schedules 
            SET course_id = :course_id, 
            class_id = :class_id, 
            date = :date, 
            start_time = :start_time, 
            end_time = :end_time 
            WHERE id = :id";
    $stmt = self::db()->prepare($sql);
    $stmt->execute(array_merge($data, ['id' => $id]));
    return $stmt->getIterator();
  }

  public static function checkExists(array $data)
  {
    $sql = "SELECT * FROM schedules 
            WHERE course_id = :course_id 
            AND class_id = :class_id 
            AND date = :date 
            AND start_time = :start_time 
            AND end_time = :end_time 
            LIMIT 1";
    $stmt = self::db()->prepare($sql);
    $stmt->execute($data);
    return $stmt->fetch(\PDO::FETCH_OBJ);
  }

  public static function all()
  {
    // get all with course name, class name, count of student, count of present
    $query = "SELECT sc.*, cls.class_name, co.course_name, 
              (SELECT COUNT(*) FROM students s WHERE s.class_id = sc.class_id) as count_of_student,
              (SELECT COUNT(*)  FROM attendance a WHERE a.status = 'present') as present
              FROM schedules sc 
              JOIN class cls ON sc.class_id = cls.id 
              JOIN courses co ON sc.course_id = co.id ORDER BY date DESC";

    $stmt = self::db()->query($query);
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  public static function getByIdWithJoin($id)
  {
    $query = "SELECT sc.*, cls.class_name, co.course_name, 
              (SELECT COUNT(*) FROM students s WHERE s.class_id = sc.class_id) as count_of_student,
              (SELECT COUNT(*)  FROM attendance a WHERE a.status = 'present') as present
              FROM schedules sc 
              JOIN class cls ON sc.class_id = cls.id 
              JOIN courses co ON sc.course_id = co.id WHERE sc.id = :id";

    $stmt = self::db()->prepare($query);
    $stmt->execute(["id" => $id]);
    return $stmt->fetch(\PDO::FETCH_OBJ);
  }
}