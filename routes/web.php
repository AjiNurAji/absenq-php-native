<?php

use App\Controllers\DashboardController;
use App\Core\Router;
use App\Core\View;

Router::get('/', function () {
  return View::render("home/index");
});

Router::get("/dashboard", [DashboardController::class, "index"]);

require __DIR__ . '/auth.php';