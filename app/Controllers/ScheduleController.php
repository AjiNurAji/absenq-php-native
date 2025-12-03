<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;
use App\Models\Classes;
use App\Models\Course;
use App\Models\Schedule;

class ScheduleController extends Controller
{
  public function index()
  {
    $schedules = Schedule::all();

    return View::render("schedule/index", [
      "title" => "Daftar Jadwal - AbsenQ",
      "titleHeader" => "Daftar Jadwal",
      "schedules" => $schedules
    ]);
  }

  public function create()
  {
    $classes = Classes::all();
    $courses = Course::all();

    return View::render("schedule/create/index", [
      "title" => "Tambah Jadwal - AbsenQ",
      "titleHeader" => "Tambah Jadwal",
      "classes" => $classes,
      "courses" => $courses,
    ]);
  }

  public function store()
  {
    // check request method
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
      http_response_code(403);
      exit("Method not allowed!");
    }

    // get data value
    $data = json_decode(file_get_contents("php://input"), true);

    // check exsists
    $check = Schedule::checkExists($data);
    if ($check) {
      http_response_code(400);
      return self::json([
        "status" => "error",
        "message" => "Jadwal untuk matakuliah ini sudah ada.",
      ]);
    }

    try {
      Schedule::create($data);

      return self::json([
        "status" => "success",
        "message" => "Berhasil menambahkan jadwal!"
      ]);

    } catch (\PDOException $e) {
      http_response_code($e->getCode());
      return self::json([
        "status" => "error",
        "message" => "Gagal menambahkan jadwal, silahkan coba lagi!"
      ]);
    }
  }

  // edit page
  public function edit($id)
  {
    $classes = Classes::all();
    $courses = Course::all();

    return View::render("schedule/edit/index", [
      "title" => "Edit Jadwal - AbsenQ",
      "titleHeader" => "Edit Jadwal",
      "schedule" => Schedule::getById($id),
      "classes" => $classes,
      "courses" => $courses,
    ]);
  }

  public function update($id)
  {
    // check request method
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
      http_response_code(403);
      exit("Method not allowed!");
    }

    // get data value
    $data = json_decode(file_get_contents("php://input"), true);

    // check exsists
    $check = Schedule::checkExists($data);
    if ($check) {
      http_response_code(400);
      return self::json([
        "status" => "error",
        "message" => "Jadwal untuk matakuliah ini sudah ada.",
      ]);
    }

    try {
      Schedule::update($id, $data);

      return self::json([
        "status" => "success",
        "message" => "Berhasil mengubah jadwal!"
      ]);

    } catch (\PDOException $e) {
      http_response_code($e->getCode());
      return self::json([
        "status" => "error",
        "message" => "Gagal mengubah jadwal, silahkan coba lagi!"
      ]);
    }
  }

  public function delete()
  {
    // validate request is post
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
      http_response_code(405);
      exit("Method not allowed");
    }

    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data["id"];

    try {
      Schedule::delete($id);
      return self::json([
        "status" => "success",
        "message" => "Berhasil menghapus jadwal!"
      ]);
    } catch (\PDOException $e) {
      http_response_code($e->getCode());
      return self::json([
        "status" => "error",
        "message" => "Gagal menghapus jadwal!",
      ]);
    }
  }

  public function scan($id)
  {
    $schedule = Schedule::getByIdWithJoin($id);

    return View::render("schedule/scan/index", [
      "title" => "Scan QR - AbsenQ",
      "titleHeader" => "Scan QR",
      "schedule" => $schedule
    ]);
  }
}
