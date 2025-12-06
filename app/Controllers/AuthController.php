<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;
use App\Models\Student;
use App\Models\User;

class AuthController extends Controller
{
  public function login()
  {
    // If user is already logged in, redirect to dashboard
    if (isset($_SESSION["user"])) {
      self::redirect("/dashboard");
      return;
    }

    return View::render("auth/login", [
      "title" => "Login - AbsenQ"
    ]);
  }

  public function loginPost()
  {
    // If method is not POST, redirect to login page
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
      self::redirect("/login");
      return;
    }
    
    $post = json_decode(file_get_contents("php://input"), true);

    // Handle login logic here
    $username = $post["username"] ?? "";
    $password = $post["password"] ?? "";

    $user = User::findUsername($username);

    if ($user && password_verify($password, $user->password)) {
      // Successfull login
      $_SESSION["user"] = [
        "name" => $user->username,
        "role" => $user->role ?? "admin"
      ];

      return self::json([
        "status" => "success",
        "message" => "Login berhasil"
      ]);
    }

    // check is student login
    $student = Student::get($username);
    if ($student && password_verify($password, $student->password)) {
      // Successfull login
      $_SESSION["user"] = [
        "name" => $student->name,
        "student_id" => $student->student_id,
        "class_id" => $student->class_id,
        "role" => "student"
      ];

      return self::json([
        "status" => "success",
        "message" => "Login berhasil"
      ]);
    }

    // Failed login
    http_response_code(401);
    return self::json([
      "status" => "error",
      "message" => "Username atau password salah"
    ]);
  }

  public function logout()
  {
    // Destroy session
    session_destroy();

    // Redirect to login page
    self::redirect("/login");
  }
}
