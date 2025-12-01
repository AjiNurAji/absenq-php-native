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

  public static function all()
  {
    // get all with course name, class name, count of student, count of present
    $query = "SELECT sc.*, cls.class_name, co.course_name, 
              (SELECT COUNT(*) FROM students s WHERE s.class_id = sc.class_id) as count_of_student,
              (SELECT COUNT(*)  FROM attendance a WHERE a.status = 'present') as present
              FROM schedules sc 
              JOIN class cls ON sc.class_id = cls.id 
              JOIN courses co ON sc.course_id = co.id";

    $stmt = self::db()->query($query);
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }
}