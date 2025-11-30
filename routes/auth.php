<?php
use App\Controllers\AuthController;
use App\Core\Router;
use App\Middlewares\AuthMiddleware;

Router::post("/login", [AuthController::class, "loginPost"]);
Router::get("/login", [AuthController::class, "login"]);

// logout route
Router::post("/logout", [AuthController::class, "logout"], [
  AuthMiddleware::class
]);