<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;

class DashboardController extends Controller
{
  public function index()
  {
    // If user is not logged in, redirect to login page
    if (!isset($_SESSION["username"]) && !isset($_SESSION["student_id"])) {
      self::redirect("/login");
      return;
    }

    return View::render("dashboard/index", [
      "title" => "Dashboard - AbsenQ",
    ]);
  }
}