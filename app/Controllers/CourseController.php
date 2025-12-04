<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;
use App\Models\Course;

class CourseController extends Controller
{
  public function index()
  {
    return View::render("course/index", [
      "courses" => Course::all(),
      "title" => "Mata Kuliah - AbsenQ",
      "titleHeader" => "Daftar Mata Kuliah"
    ]);
  }

  public function create()
  {
    return View::render("course/create/index", [
      "title" => "Mata Kuliah - AbsenQ",
      "titleHeader" => "Tambah Mata Kuliah"
    ]);
  }

  public function store()
  {
    // validate request is post
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
      http_response_code(405);
      exit("Method not allowed");
    }

    $data = json_decode(file_get_contents("php://input"), true);

    if (Course::findByName($data["name"])) {
      http_response_code(400);
      return self::json([
        "status" => "error",
        "message" => "Mata kuliah sudah ada!"
      ]);
    }

    try {
      Course::create([
        "course_name" => $data["name"],
      ]);
      return self::json([
        "status" => "success",
        "message" => "Berhasil menambahkan mata kuliah!"
      ]);
    } catch (\PDOException $e) {
      http_response_code(500);
      return self::json([
        "status" => "error",
        "message" => "Gagal menambahkan mata kuliah!"
      ]);
    }
  }

  public function delete()
  {
    // validate request is post
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
      http_response_code(405);
      exit("Method not allowed");
    }

    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data["id"];

    try {
      Course::delete($id);
      return self::json([
        "status" => "success",
        "message" => "Berhasil menghapus mata kuliah!"
      ]);
    } catch (\PDOException $e) {
      http_response_code(500);
      return self::json([
        "status" => "error",
        "message" => "Gagal menghapus mata kuliah!",
      ]);
    }
  }

  public function edit($id)
  {
    return View::render("course/edit/index", [
      "course" => Course::find($id),
      "title" => "Mata Kuliah - AbsenQ",
      "titleHeader" => "Ubah Mata Kuliah"
    ]);
  }

  public function update($id)
  {
    // validate request is post
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
      http_response_code(405);
      exit("Method not allowed");
    }

    // data 
    $data = json_decode(file_get_contents("php://input"), true);

    if (Course::findByName($data["name"])) {
      http_response_code(400);
      return self::json([
        "status" => "error",
        "message" => "Mata kuliah sudah ada!"
      ]);
    }

    try {
      Course::update($id, [
        "course_name" => $data["name"]
      ]);
      return self::json([
        "status" => "success",
        "message" => "Berhasil mengubah mata kuliah!"
      ]);
    } catch (\PDOException $e) {
      http_response_code(500);
      return self::json([
        "status" => "error",
        "message" => "Gagal mengubah mata kuliah!"
      ]);
    }
  }
}