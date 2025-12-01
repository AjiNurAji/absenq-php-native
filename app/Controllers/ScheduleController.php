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
}
