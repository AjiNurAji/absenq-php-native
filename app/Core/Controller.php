<?php

namespace App\Core;

class Controller
{

  // if session not started, start session
  public function __construct()
  {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
  }

  public static function json($data)
  {
    header('Content-Type: application/json');
    echo json_encode($data);
  }

  public static function redirect(string $path)
  {
    $path = (getenv("APP_URL") ? rtrim(getenv("APP_URL"), "/") . "/" . ltrim($path, "/") : $path);
    header("Location: " . $path);
    exit;
  }
}
