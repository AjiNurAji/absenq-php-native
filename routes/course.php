<?php

use App\Controllers\CourseController;
use App\Core\Router;
use App\Middlewares\AuthMiddleware;

Router::get("/courses", [CourseController::class, "index"], [
  [AuthMiddleware::class, "admin"]
]);

Router::get("/course/create", [CourseController::class, "create"], [
  [AuthMiddleware::class, "admin"]
]);

Router::post("/course/create", [CourseController::class, "store"], [
  [AuthMiddleware::class, "admin"]
]);

Router::get("/course/{id}", [CourseController::class, "edit"], [
  [AuthMiddleware::class, "admin"]
]);

Router::post("/course/edit/{id}", [CourseController::class, "update"], [
  [AuthMiddleware::class, "admin"]
]);

Router::post("/course/delete", [CourseController::class, "delete"], [
  [AuthMiddleware::class, "admin"]
]);