<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;
use App\Helpers\QR;
use App\Helpers\StrHelper;
use App\Models\Classes;
use App\Models\Student;

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
      http_response_code(500);
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

  public function edit(string $id)
  {
    // find student
    $student = Student::get($id);

    return View::render("student/edit/index", [
      "classes" => Classes::all(),
      "title" => "AbsenQ - Edit Mahasiswa",
      "titleHeader" => "Edit Mahasiswa",
      "data" => $student
    ]);
  }

  public function update(string $id)
  {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
      http_response_code(405);
      exit("Method not allowed");
    }

    $data = json_decode(file_get_contents("php://input"), true);

    try {
      Student::update($id, [
        "name" => $data["name"],
        "class_id" => $data["class_id"],
        "password" => $data["password"],
      ]);

      return self::json([
        "status" => "success",
        "message" => "Berhasil mengubah data mahasiswa",
      ]);
    } catch (\PDOException $e) {
      return self::json([
        "status" => "error",
        "message" => "Gagal mengubah data mahasiswa, silahkan coba lagi!",
      ]);
    }
  }

  public function qr()
  {
    return View::render("student/qr", [
      "title" => "QR Mahasiswa - AbsenQ"
    ]);
  }

  public function qrImage()
  {
    // validate is method post
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
      http_response_code(405);
      exit("Method not allowed");
    }

    $student = $_SESSION["user"];

    // create random unique id
    $randomId = StrHelper::uuid();
    $lifetime = 4 * 60; // 4 minutes
    $exp = time() + $lifetime;

    // payload format for QR ABSENQ|STUDENT|ID_QR|ID_STUDENT|EXPIRED
    $payload = "ABSENQ|STUDENT|".$randomId."|".$student["student_id"]."|".$exp;

    if (!$student) {
      die("Invalid QR request");
    }

    // Build QR image
    $result = QR::generate($payload, $student["name"]);
    $base64image = "data:" . $result->getMimeType() . ";base64," . base64_encode($result->getString());

    return self::json([
      "status" => "success",
      "message" => "QR berhasil dibuat silahkan gunakan selama 4 menit.",
      "qr_code" => [
        "qr_image" => $base64image,
        "exp" => $exp,
        "remaining" => $lifetime
      ],
    ]);
  }
}
