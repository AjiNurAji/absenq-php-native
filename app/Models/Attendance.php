<?php

namespace App\Models;

use App\Core\Model;

class Attendance extends Model
{
  public static function all()
  {
    $sql = "SELECT a.*, sc.*, st.name as student_name, c.*, cls.*
            FROM attendance a
            JOIN schedules sc ON sc.id = a.schedule_id
            JOIN students st ON st.student_id = a.student_id
            JOIN courses c ON c.id = sc.course_id
            JOIN class cls ON  cls.id = sc.class_id
            ORDER BY a.created_at DESC";
    $stmt = self::db()->query($sql);

    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  public static function allByStudentId(string $student_id)
  {
    $sql = "SELECT a.*, sc.*, st.name as student_name, c.*, cls.*
            FROM attendance a
            JOIN schedules sc ON sc.id = a.schedule_id
            JOIN students st ON st.student_id = a.student_id
            JOIN courses c ON c.id = sc.course_id
            JOIN class cls ON  cls.id = sc.class_id
            WHERE a.student_id = :student_id
            ORDER BY a.created_at DESC";
    $stmt = self::db()->prepare($sql);
    $stmt->execute(["student_id" => $student_id]);
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  public static function countOfPresent(string $status)
  {
    $sql = "SELECT 
                present.present_count,
                total.total_students,
                (present.present_count / total.total_students) * 100 AS percentage
            FROM 
                (SELECT COUNT(*) AS present_count
                FROM attendance a
                JOIN schedules s ON s.id = a.schedule_id
                WHERE DATE(s.date) = CURDATE() AND a.status = :status) AS present,
                (SELECT COUNT(*) AS total_students
                FROM students) AS total;
            ";

    $stmt = self::db()->prepare($sql);
    $stmt->execute(["status" => $status]);
    return $stmt->fetch(\PDO::FETCH_OBJ);
  }

  public static function weeklyPresentCount(string $status)
  {
    $sql = "SELECT 
                DATE(s.date) AS day,
                COUNT(*) AS present_count
            FROM attendance a
            JOIN schedules s ON s.id = a.schedule_id
            WHERE s.date BETWEEN DATE_SUB(CURDATE(), INTERVAL 6 DAY) AND CURDATE()
              AND a.status = :status
            GROUP BY DATE(s.date)
            ORDER BY day ASC;";

    $stmt = self::db()->prepare($sql);
    $stmt->execute(["status" => $status]);
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  public static function monthlyAttendanceTrend(string $status = 'present')
  {
    $sql = "SELECT 
                DATE_FORMAT(s.date, '%Y-%m') AS ym,
                COUNT(*) AS total_present
            FROM attendance a
            JOIN schedules s ON s.id = a.schedule_id
            WHERE a.status = :status
              AND s.date >= DATE_SUB(DATE_FORMAT(CURDATE(), '%Y-%m-01'), INTERVAL 5 MONTH)
            GROUP BY ym
            ORDER BY ym ASC";

    $stmt = self::db()->prepare($sql);
    $stmt->execute(['status' => $status]);

    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  public static function getAvgPerMonth()
  {
    $sql = "SELECT
              (SELECT AVG(daily_count) 
              FROM (
                  SELECT DATE(created_at) AS day, COUNT(*) AS daily_count
                  FROM attendance
                  WHERE MONTH(created_at) = MONTH(CURDATE())
                    AND YEAR(created_at) = YEAR(CURDATE())
                  GROUP BY DATE(created_at)
              ) AS tm
              ) AS avg_this_month,

              (SELECT AVG(daily_count) 
              FROM (
                  SELECT DATE(created_at) AS day, COUNT(*) AS daily_count
                  FROM attendance
                  WHERE MONTH(created_at) = MONTH(CURDATE() - INTERVAL 1 MONTH)
                    AND YEAR(created_at) = YEAR(CURDATE() - INTERVAL 1 MONTH)
                  GROUP BY DATE(created_at)
              ) AS lm
              ) AS avg_last_month;";

    $stmt = self::db()->query($sql);
    return $stmt->fetch(\PDO::FETCH_OBJ);
  }

  public static function getById(string $student_id, $schedule_id)
  {
    $sql = "SELECT * FROM attendance 
            WHERE student_id = :id 
            AND schedule_id = :schedule_id
            ORDER BY created_at DESC LIMIT 1";
    $stmt = self::db()->prepare($sql);

    $stmt->execute([
      "id" => $student_id,
      "schedule_id" => $schedule_id
    ]);

    return $stmt->fetch(\PDO::FETCH_OBJ);
  }

  public static function log(array $data)
  {
    $sql = "INSERT INTO attendance (student_id, schedule_id, in_time, status, note) VALUES (:student_id, :schedule_id, NOW(), :status, :note)";
    $stmt = self::db()->prepare($sql);
    return $stmt->execute($data);
  }

  public static function logAbsent(array $data)
  {
    $sql = "INSERT INTO attendance (student_id, schedule_id, in_time, out_time, status, note) VALUES (:student_id, :schedule_id, NOW(), NOW(), :status, :note)";
    $stmt = self::db()->prepare($sql);
    return $stmt->execute($data);
  }

  public static function logOut(array $data)
  {
    $sql = "UPDATE attendance 
            SET out_time = NOW(), 
            updated_at = NOW() 
            WHERE student_id = :student_id 
            AND schedule_id = :schedule_id";
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
    $sql = "SELECT a.*,sc.*, c.*
            FROM attendance a
            JOIN schedules sc ON sc.id = a.schedule_id
            JOIN courses c ON c.id = sc.course_id
            WHERE a.student_id = :id ORDER BY a.id DESC LIMIT 1";

    $stmt = self::db()->prepare($sql);
    $stmt->execute(['id' => $student_id]);
    return $stmt->fetch(\PDO::FETCH_OBJ);
  }

  public static function upcomingAttendance($class_id, string $student_id)
  {
    $sql = "SELECT s.*, c.course_name, 
            (SELECT 1 FROM attendance a 
                  WHERE a.schedule_id = s.id
                    AND a.student_id = :student_id) as attendance_student
            FROM schedules s
            JOIN courses c ON c.id = s.course_id
            WHERE s.class_id = :class_id
              AND TIMESTAMP(s.date, s.start_time) > NOW()
              AND NOT EXISTS (
                  SELECT 1 FROM attendance a 
                  WHERE a.schedule_id = s.id
                    AND a.student_id = :student_id
                    AND a.out_time IS NOT NULL
              )
            ORDER BY s.date ASC, s.start_time ASC
            LIMIT 1";

    $stmt = self::db()->prepare($sql);
    $stmt->execute(['class_id' => $class_id, "student_id" => $student_id]);
    return $stmt->fetch(\PDO::FETCH_OBJ);
  }

  public static function checkAttendance(string $schedule_id, string $student_id)
  {
    $sql = "SELECT * FROM attendance a 
            WHERE a.schedule_id = :schedule_id
              AND a.student_id = :student_id";

    $stmt = self::db()->prepare($sql);
    $stmt->execute(['schedule_id' => $schedule_id, "student_id" => $student_id]);
    return $stmt->fetch(\PDO::FETCH_OBJ);
  }
}
