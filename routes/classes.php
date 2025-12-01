<?php

use App\Controllers\ClassesController;
use App\Core\Router;
use App\Middlewares\AuthMiddleware;

Router::get("/classes", [ClassesController::class, "index"], [
  [AuthMiddleware::class, "admin"]
]);

// create route
Router::get("/class/create", [ClassesController::class, "create"], [
  [AuthMiddleware::class, "admin"]
]);
Router::post("/class/create", [ClassesController::class, "store"], [
  [AuthMiddleware::class, "admin"]
]);

// edit route
Router::get("/class/{id}", [ClassesController::class, "show"], [
  [AuthMiddleware::class, "admin"]
]);
Router::post("/class/edit/{id}", [ClassesController::class, "update"], [
  [AuthMiddleware::class, "admin"]
]);

// delete route
Router::post("/class/delete", [ClassesController::class, "delete"], [
  [AuthMiddleware::class, "admin"]
]);