<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;
use App\Models\Attendance;
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

      // Get count of students
      $count_of_student = Student::getCount();

      return View::render("dashboard/index", [
        "title" => "Dashboard - AbsenQ",
        "count_of_student" => $count_of_student,
      ]);
    }

    $user = Student::get($_SESSION["user"]["student_id"]);

    // get new attendance or scheduler attendance
   $lastAttendance = Attendance::lastAttendance($user->student_id);
   $upcomingAttendance = Attendance::upcomingAttendance($user->class_id, $user->student_id);

    // $attendance = Attendance::listBySchedule()

    // var_dump($lastAttendance);
    // var_dump($upcomingAttendance);

    return View::render("student/home", [
      "title" => "Dashboard - AbsenQ",
      "lastAttendance" => $lastAttendance,
      "upcomingAttendance" => $upcomingAttendance
    ]);
  }
}