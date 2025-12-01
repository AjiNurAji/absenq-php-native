<?php

use App\Controllers\DashboardController;
use App\Core\Router;
use App\Core\View;
use App\Middlewares\AuthMiddleware;

Router::get("/", function () {
  return View::render("home/index");
});

Router::get("/dashboard", [DashboardController::class, "index"], [
  AuthMiddleware::class
]);

require __DIR__ . "/auth.php";
require __DIR__ . "/attendance.php";
require __DIR__ . "/student.php";
require __DIR__ . "/classes.php";
require __DIR__ . "/course.php";
require __DIR__ . "/schedule.php";