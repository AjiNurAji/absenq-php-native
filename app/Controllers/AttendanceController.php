<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;
use App\Models\Attendance;

class AttendanceController extends Controller
{
  public function scanPage()
  {
    return View::render("student/scan");
  }

  public function scanSubmit()
  {
    $json = json_decode(file_get_contents("php://input"), true);
    $qr = $json["qr"] ?? "";

    // format QR yang valid
    // ABSENQ|STUDENT|123|TI-2024-PX|Matematika Diskrit
    $parts = explode("|", $qr);

    if (count($parts) !== 5 || $parts[0] !== "ABSENQ" || $parts[1] !== "STUDENT") {
      return self::json([
        "status" => "error",
        "message" => "QR tidak valid"
      ]);
    }

    $studentId = $parts[2];
    $scheduleId = $parts[3] ?? null;

    // Catat absensi
    Attendance::log($studentId);

    return self::json([
      "status" => "success",
      "message" => "Absensi berhasil dicatat!"
    ]);
  }
}
