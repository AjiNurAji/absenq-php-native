<?php
use App\Controllers\AuthController;
use App\Core\Router;

Router::post("/login", [AuthController::class, "loginPost"]);
Router::get("/login", [AuthController::class, "login"]);

// logout route
Router::post("/logout", [AuthController::class, "logout"]);