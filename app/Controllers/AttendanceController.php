<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;
use App\Helpers\BlockQR;
use App\Models\Attendance;
use App\Models\Student;

class AttendanceController extends Controller
{
  public function scanSubmit()
  {
    $json = json_decode(file_get_contents("php://input"), true);
    $qr = $json["qr"] ?? "";
    // format for QR ABSENQ|STUDENT|ID_QR|ID_STUDENT|EXPIRED
    $parts = explode("|", $qr);

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

    if (isset($check) && $check->type == "out") {
      http_response_code(400);
      return self::json([
        "status" => "error",
        "message" => "Anda sudah melakukan abasensi secara lengkap!"
      ]);
    }

    $isUsed = BlockQR::isUsed($parts[2]);

    if ($isUsed) {
      http_response_code(400);
      return self::json([
        "status" => "error",
        "message" => "QR ini sudah digunakan silahkan generate ulang",
      ]);
    }

    $data = [
      "student_id" => $parts[3],
      "schedule_id" => $json["schedule_id"],
      "type" => $check ? "out" : "in",
      "status" => "present",
      "note" => "Hadir"
    ];

    try {
      // Catat absensi
      Attendance::log($data);

      // insert id qr to log
      BlockQR::markUsed($parts[2]);

      return self::json([
        "status" => "success",
        "message" => "Absensi berhasil dicatat!",
        "student" => Student::get($parts[3]),
      ]);
    } catch (\PDOException $e) {
      http_response_code($e->getCode());
      return self::json([
        "status" => "success",
        "message" => "Ada kesalahan silahkan coba lagi",
      ]);
    }
  }
}
