<?php

namespace App\Models;

use App\Core\Model;

class Attendance extends Model
{
  public static function log(string $student_id, string $schedule_id, $status)
  {
    $sql = "INSERT INTO attendances (student_id, schedule_id, status, timestamp) 
            VALUES (:student_id, :schedule_id, :status, NOW())";

    $stmt = self::db()->prepare($sql);
    return $stmt->execute([
      'student_id' => $student_id,
      'schedule_id' => $schedule_id,
      'status' => $status
    ]);
  }

  public static function listBySchedule(string $schedule_id)
  {
    $sql = "SELECT a.*, s.name AS student_name
            FROM attendances a
            JOIN students s ON s.student_id = a.student_id
            WHERE a.schedule_id = :schedule_id";

    $stmt = self::db()->prepare($sql);
    $stmt->execute(['schedule_id' => $schedule_id]);
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }
}
