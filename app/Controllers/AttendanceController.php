<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;
use App\Helpers\BlockQR;
use App\Models\Attendance;
use App\Models\Schedule;
use App\Models\Student;

class AttendanceController extends Controller
{
  public function index()
  {
    return View::render("attendance/index", [
      "title" => "Daftar Absensi - AbsenQ",
      "titleHeader" => "Daftar Absensi",
      "attendances" => Attendance::all()
    ]);
  }

  public function hisotyStudent()
  {
    $user = $_SESSION["user"];

    return View::render("student/history/index", [
      "title" => "Riwayat Absensi - AbsenQ",
      "titleHeader" => "Riwayat Absensi",
      "attendances" => Attendance::allByStudentId($user["student_id"])
    ]);
  }

  public function scanSubmit()
  {
    $json = json_decode(file_get_contents("php://input"), true);
    $qr = $json["qr"] ?? "";
    // format for QR ABSENQ|STUDENT|ID_QR|ID_STUDENT|EXPIRED
    $parts = explode("|", $qr);

    // check start time
    $schedule = Schedule::getById($json["schedule_id"]);
    $student = Student::get($parts[3]);

    if ($schedule) {
      if ($schedule->class_id !== $student->class_id) {
        http_response_code(403);
        return self::json([
          "status" => "error",
          "message" => "Jadwal ini bukan untuk kelas anda."
        ]);
      }
    }

    // validate expired
    if ((int) $parts[4] <= time()) {
      http_response_code(400);
      return self::json([
        "status" => "error",
        "message" => "QR sudah kadaluarsa",
        "time" => time(),
        "exp" => $parts[4]
      ]);
    }

    if (count($parts) !== 5 || $parts[0] !== "ABSENQ" || $parts[1] !== "STUDENT") {
      http_response_code(400);
      return self::json([
        "status" => "error",
        "message" => "QR tidak valid"
      ]);
    }

    // check if exists attendance in set out
    $check = Attendance::getById($parts[3], $json["schedule_id"]);

    if ($check) {
      if ($check->out_time) {
        http_response_code(400);
        return self::json([
          "status" => "error",
          "message" => "Anda sudah melakukan abasensi secara lengkap!"
        ]);
      }
    }

    $isUsed = BlockQR::isUsed($parts[2]);

    if ($isUsed) {
      http_response_code(400);
      return self::json([
        "status" => "error",
        "message" => "QR ini sudah digunakan silahkan generate ulang",
      ]);
    }

    try {
      // Catat absensi
      if ($check) {
        if (!$check->out_time) {
          Attendance::logOut([
            "student_id" => $parts[3],
            "schedule_id" => $json["schedule_id"]
          ]);
        }
      } else {
        Attendance::log([
          "student_id" => $parts[3],
          "schedule_id" => $json["schedule_id"],
          "status" => "present",
          "note" => "Hadir"
        ]);
      }

      // insert id qr to log
      BlockQR::markUsed($parts[2]);

      return self::json([
        "status" => "success",
        "message" => "Absensi berhasil dicatat!",
        "student" => Student::get($parts[3]),
      ]);
    } catch (\PDOException $e) {
      http_response_code(500);
      return self::json([
        "status" => "success",
        "message" => "Ada kesalahan silahkan coba lagi",
      ]);
    }
  }

  public function chartWeekly()
  {
    $weeklyPresent = Attendance::weeklyPresentCount("present");
    $weeklyAbsent = Attendance::weeklyPresentCount("absent");

    // ==== Weekly ====
    $weekLabels = [];
    $weekValuesPresent = [];
    $weekValuesAbsent = [];

    $period = new \DatePeriod(
      new \DateTime("-6 days"),
      new \DateInterval("P1D"),
      new \DateTime("tomorrow")
    );

    $mapWeekPresent = [];
    foreach ($weeklyPresent as $row) {
      $mapWeekPresent[$row->day] = $row->present_count;
    }

    $mapWeekAbsent = [];

    foreach ($weeklyAbsent as $row) {
      $mapWeekAbsent[$row->day] = $row->present_count;
    }

    foreach ($period as $date) {
      $day = $date->format("Y-m-d");
      $weekLabels[] = $date->format("D"); // Sen, Sel, Rab...
      $weekValuesPresent[] = $mapWeekPresent[$day] ?? 0;
      $weekValuesAbsent[] = $mapWeekAbsent[$day] ?? 0;
    }

    return self::json([
      "present" => [
        "labels" => $weekLabels,
        "values" => $weekValuesPresent
      ],
      "absent" => [
        "labels" => $weekLabels,
        "values" => $weekValuesAbsent
      ],
    ]);
  }

  public function chartMonthly()
  {
    $monthly = Attendance::monthlyAttendanceTrend('present');

    $monthLabels = [];
    $monthValues = [];

    $months = [];
    for ($i = 5; $i >= 0; $i--) {
      $key = date('Y-m', strtotime("-$i month"));
      $months[$key] = 0;
    }

    foreach ($monthly as $row) {
      $months[$row->ym] = $row->total_present;
    }

    foreach ($months as $ym => $val) {
      $monthLabels[] = date('M', strtotime($ym . '-01')); // Jan, Feb, etc
      $monthValues[] = $val;
    }

    return self::json([
      "labels" => $monthLabels,
      "values" => $monthValues
    ]);
  }

  public function absent(string $schedule_id)
  {
    return View::render("student/absent/index", [
      "title" => "Pengajuan Izin Kehadiran - AbsenQ",
      "titleHeader" => "Pengajuan Izin Kehadiran",
      "schedule_id" => $schedule_id
    ]);
  }

  public function absentPost()
  {
    // validate req method
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
      http_response_code(400);
      return self::json([
        "status" => "error",
        "message" => "Invalid request method"
      ]);
    }

    $student = $_SESSION["user"];
    $json = json_decode(file_get_contents("php://input"), true);

    try {
      Attendance::logAbsent([
        "student_id" => $student["student_id"],
        "schedule_id" => $json["schedule_id"],
        "status" => "absent",
        "note" => $json["note"]
      ]);

      return self::json([
        "status" => "success",
        "message" => "Berhasil mengajukan izin."
      ]);
    } catch (\PDOException $e) {
      http_response_code(500);
      return self::json([
        "status" => "error",
        "message" => "Ada kesalahan silahkan coba lagi",
        "errMesage" => $e->getMessage()
      ]);
    }
  }

  public function successAttendance()
  {
    $student = $_SESSION["user"];

    $lastAttendance = Attendance::lastAttendance($student["student_id"]);

    return View::render("student/attendance/success", [
      "title" => "Absen Berhasil - AbsenQ",
      "lastAttendance" => $lastAttendance
    ]);
  }
}