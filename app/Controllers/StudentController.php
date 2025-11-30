<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;
use App\Models\Classes;
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
  public function index()
  {
    $filterByClass = $_GET["class"] ?? null;
    $students = Student::getWithClass();

    if ($filterByClass) {
      $students = Student::getWithFilterClass($filterByClass);
    }

    return View::render("student/index", [
      "classes" => Classes::all(),
      "filter" => $filterByClass ?? 0,
      "students" => $students,
      "title" => "AbsenQ - Daftar Mahasiswa",
      "titleHeader" => "Daftar Mahasiswa"
    ]);
  }

  public function create()
  {
    return View::render("student/create/index", [
      "classes" => Classes::all(),
      "title" => "AbsenQ - Tambah Mahasiswa",
      "titleHeader" => "Tambah Mahasiswa"
    ]);
  }

  public function store()
  {
    // if not post
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
      http_response_code(405);
      exit("Method not allowed");
    }

    $data = json_decode(file_get_contents("php://input"), true);

    // check is already exists
    $isExist = Student::get($data["id_number"]);

    if ($isExist) {
      http_response_code(403);
      return self::json([
        "status" => "error",
        "message" => "Mahasiwa dengan " . $data['id_number'] . " sudah ada!."
      ]);
    }

    // hash password
    $password = password_hash($data["password"], PASSWORD_DEFAULT);

    try {
      Student::create([
        "student_id" => $data["id_number"],
        "name" => $data["name"],
        "class_id" => $data["class_id"],
        "password" => $password,
      ]);

      return self::json([
        "status" => "success",
        "message" => "Berhasil menambahkan mahasiswa",
      ]);
    } catch (\PDOException $e) {
      http_response_code($e->getCode());
      return self::json([
        "status" => "error",
        "message" => "Terjadi kesalahan silahkan coba lagi!"
      ]);
    }
  }

  public function delete()
  {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
      http_response_code(405);
      exit("Method not allowed");
    }

    $data = json_decode(file_get_contents("php://input"), true);

    try {
      Student::delete($data["student_id"]);

      return self::json([
        "status" => "success",
        "message" => "Berhasil menghapus mahasiswa",
      ]);
    } catch (\PDOException $e) {
      return self::json([
        "status" => "error",
        "message" => "Gagal menghapus mahasiswa, silahkan coba lagi!",
      ]);
    }
  }

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
    if (!isset($_SESSION["user"])) {
      self::redirect("/login");
      return;
    }

    return View::render("student/qr");
  }

  public function qrImage(): never
  {
    // validate is method post
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
      http_response_code(405);
      exit("Method not allowed");
    }

    // get any value form client
    $param = json_decode(file_get_contents("php://input"), true);

    $studentId = $_SESSION["student_id"];

    // create random unique id
    $randomId = uniqid("qr_id");

    // payload format for QR ABSENQ|STUDENT|ID_QR|ID_STUDENT|CLASS|COURSE|EXPIRED
    $payload = "ABSENQ|STUDENT|$randomId|" . $studentId["student_id"] . "|" . $param["class"] . "|" . $param["course"] . "|" . $param["expired_in"];


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
    labelText: "QR Absen: " . $studentId["name"],
    labelFont: new OpenSans(20),
    labelAlignment: LabelAlignment::Center
    )->build();

    header('Content-Type: ' . $result->getMimeType());
    echo $result->getString();
    exit;
  }
}
