<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;
use App\Models\Student;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\Font\OpenSans;
use Endroid\QrCode\Label\LabelAlignment;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;

class StudentController extends Controller
{
  public static function list()
  {
    return self::json(Student::all());
  }

  public static function get($id)
  {
    return self::json(Student::get($id));
  }

  public function qr()
  {
    // pastikan sudah login student
    if (!isset($_SESSION["student_id"])) {
      self::redirect("/login");
      return;
    }

    return View::render("student/qr");
  }

  public function qrImage()
  {
    if (!isset($_SESSION["student_id"])) {
      http_response_code(401);
      exit("Unauthorized");
    }

    // validate is method post
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
      http_response_code(405);
      exit("Method not allowed");
    }

    // get class and course from param
    // ABSENQ|STUDENT|123|TI-2024-PX|Matematika Diskrit
    $param =  json_decode(file_get_contents("php://input"), true);

    $studentId = $_SESSION["student_id"];

    // create random unique id
    $randomId = uniqid("qr_id");

    $payload = "ABSENQ|STUDENT|$randomId|" . $studentId["student_id"] . "|" . $param["class"] . "|". $param["course"]."|" . $param["date"];


    if (!$studentId) {
      die("Invalid QR request");
    }

    // Build QR image
    $result = new Builder(
      writer: new PngWriter(),
      writerOptions: [],
      validateResult: false,
      data: $payload,
      encoding: new Encoding('UTF-8'),
      errorCorrectionLevel: ErrorCorrectionLevel::High,
      size: 300,
      margin: 10,
      roundBlockSizeMode: RoundBlockSizeMode::Margin,
      // logoPath: __DIR__ . '/assets/bender.png',
      // logoResizeToWidth: 50,
      // logoPunchoutBackground: true,
      labelText: "QR Absen: ".$studentId["name"],
      labelFont: new OpenSans(20),
      labelAlignment: LabelAlignment::Center
    )->build();

    header('Content-Type: ' . $result->getMimeType());
    echo $result->getString();
    exit;
  }
}
