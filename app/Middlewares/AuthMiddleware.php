<?php

namespace App\Middlewares;

use App\Core\Middleware;

class AuthMiddleware implements Middleware
{
  public function __construct()
  {
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
  }

  public static function handle(): bool
  {
    if (!isset($_SESSION["user"])) {
      header("Location: /login");
      exit();
    }

    return true;
  }

  public static function student(): bool
  {
    $user = $_SESSION["user"] ?? null;

    if ($user["role"] !== "student") {
      http_response_code(403);
      echo "403 Forbidden - You do not have permission to access this resource.";
      exit();
    }

    return true;
  }

  public static function admin(): bool
  {
    $user = $_SESSION["user"] ?? null;

    if ($user["role"] !== "admin" && $user["role"] !== "employee") {
      http_response_code(403);
      echo "403 Forbidden - You do not have permission to access this resource.";
      exit();
    }

    return true;
  }
}