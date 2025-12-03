<?php

use App\Controllers\ScheduleController;
use App\Core\Router;
use App\Middlewares\AuthMiddleware;

Router::get("/schedules", [ScheduleController::class, "index"], [
  [AuthMiddleware::class, "admin"]
]);

Router::get("/schedule/create", [ScheduleController::class, "create"], [
  [AuthMiddleware::class, "admin"]
]);

Router::post("/schedule/create", [ScheduleController::class, "store"], [
  [AuthMiddleware::class, "admin"]
]);

Router::get("/schedule/{id}", [ScheduleController::class, "edit"], [
  [AuthMiddleware::class, "admin"]
]);

Router::post("/schedule/update/{id}", [ScheduleController::class, "update"], [
  [AuthMiddleware::class, "admin"]
]);

Router::post("/schedule/delete", [ScheduleController::class, "delete"], [
  [AuthMiddleware::class, "admin"]
]);

// scan
Router::get("/schedule/{id}/scan", [ScheduleController::class, "scan"], [
  [AuthMiddleware::class, "admin"]
]);