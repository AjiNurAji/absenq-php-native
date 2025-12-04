<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;
use App\Models\Attendance;
use App\Models\Schedule;
use App\Models\Student;

class DashboardController extends Controller
{
  public function index()
  {
    $user = $_SESSION["user"] ?? null;
    // If user is not logged in, redirect to login page
    if (!$user) {
      self::redirect("/login");
      return;
    }

    if ($user['role'] === 'admin') {
      // get present now
      $presentToDay = Attendance::countOfPresent("present");
      $absenToDay = Attendance::countOfPresent("absent");
      $avgPerMonth = Attendance::getAvgPerMonth();

      return View::render("dashboard/index", [
        "title" => "Dashboard - AbsenQ",
        "presentToDay" => $presentToDay,
        "avgPerMonth" => $avgPerMonth,
        "notScan" => $presentToDay->present_count - $absenToDay->present_count
      ]);
    }

    $user = Student::get($_SESSION["user"]["student_id"]);

    // get new attendance or scheduler attendance
    $lastAttendance = Attendance::lastAttendance($user->student_id);
    $upcomingAttendance = Attendance::upcomingAttendance($user->class_id, $user->student_id);

    return View::render("student/home", [
      "title" => "Dashboard - AbsenQ",
      "lastAttendance" => $lastAttendance,
      "upcomingAttendance" => $upcomingAttendance,
    ]);
  }
}