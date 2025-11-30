<?php

use App\Controllers\StudentController;
use App\Core\Router;
use App\Middlewares\AuthMiddleware;


Router::get("/students", [StudentController::class, "index"], [
  [AuthMiddleware::class, "admin"]
]);

Router::get("/student/create", [StudentController::class, "create"], [
  [AuthMiddleware::class, "admin"]
]);

Router::get("/student/{id}", [StudentController::class, "edit"], [
  [AuthMiddleware::class, "admin"]
]);

Router::post("/student/update/{id}", [StudentController::class, "update"], [
  [AuthMiddleware::class, "admin"]
]);

Router::post("/student/create", [StudentController::class, "store"], [
  [AuthMiddleware::class, "admin"]
]);

Router::post("/student/delete", [StudentController::class, "delete"], [
  [AuthMiddleware::class, "admin"]
]);