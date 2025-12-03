<?php

namespace App\Models;

use App\Core\Model;

class Attendance extends Model
{
  public static function getById(string $student_id, $schedule_id)
  {
    $sql = "SELECT * FROM attendance 
            WHERE student_id = :id 
            AND schedule_id = :schedule_id 
            AND type = 'in'
            ORDER BY time DESC LIMIT 1";
    $stmt = self::db()->prepare($sql);

    $stmt->execute([
      "id" => $student_id,
      "schedule_id" => $schedule_id
    ]);

    return $stmt->fetch(\PDO::FETCH_OBJ);
  }

  public static function log(array $data)
  {
    $sql = "INSERT INTO attendance (student_id, schedule_id, type, status, note, time) VALUES (:student_id, :schedule_id, :type, :status, :note, NOW())";
    $stmt = self::db()->prepare($sql);
    return $stmt->execute($data);
  }

  public static function listBySchedule(string $schedule_id)
  {
    $sql = "SELECT a.*, s.name AS student_name
            FROM attendance a
            JOIN students s ON s.student_id = a.student_id
            WHERE a.schedule_id = :schedule_id";

    $stmt = self::db()->prepare($sql);
    $stmt->execute(['schedule_id' => $schedule_id]);
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  public static function lastAttendance(string $student_id)
  {
    $sql = "SELECT a.*,sc.*
            FROM attendance a
            JOIN schedules sc ON sc.id = a.schedule_id
            WHERE a.student_id = :id ORDER BY a.id DESC LIMIT 1";

    $stmt = self::db()->prepare($sql);
    $stmt->execute(['id' => $student_id]);
    return $stmt->fetch(\PDO::FETCH_OBJ);
  }

  public static function upcomingAttendance($class_id, string $student_id)
  {
    $sql = "SELECT s.*, c.*
            FROM schedules s
            JOIN courses c ON c.id = s.course_id
            WHERE s.class_id = :class_id
              AND TIMESTAMP(s.date, s.start_time) > NOW()
              AND NOT EXISTS (
                  SELECT 1 FROM attendance a 
                  WHERE a.schedule_id = s.id
                    AND a.student_id = :student_id
                    AND a.type = 'out'
              )
            ORDER BY s.date ASC, s.start_time ASC
            LIMIT 1";

    $stmt = self::db()->prepare($sql);
    $stmt->execute(['class_id' => $class_id, "student_id" => $student_id]);
    return $stmt->fetch(\PDO::FETCH_OBJ);
  }
}
