<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Schedule;

class ScheduleController extends Controller
{
  public static function create()
  {
    Schedule::create([
      "course" => $_POST["course"],
      "class" => $_POST["class"],
      "date" => $_POST["date"],
      "start_time" => $_POST["start_time"],
      "end_time" => $_POST["end_time"]
    ]);

    return self::json(["success" => true, "message" => "Jadwal berhasil ditambahkan."]);
  }

  public static function list()
  {
    return self::json(Schedule::all());
  }
}
