<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;
use App\Models\Classes;

class ClassesController extends Controller
{

  public function index()
  {
    return View::render("/classes/index", [
      "title" => "Kelas - AbsenQ",
      "titleHeader" => "Daftar Kelas",
      "classes" => Classes::all(),
    ]);
  }

  public function create()
  {
    return View::render("/classes/create/index", [
      "title" => "Tambah Kelas - AbsenQ",
      "titleHeader" => "Tambah Kelas",
    ]);
  }

  public function store()
  {
    // validate method
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
      http_response_code(405);
      exit("Method not allowed");
    }

    $data = json_decode(file_get_contents("php://input"), true);

    // check is name already exists
    if (Classes::findByName($data["name"])) {
      http_response_code(400);
      return self::json([
        "status" => "error",
        "message" => "Kelas sudah ada!",
      ]);
    }

    try {
      Classes::create($data);
      return self::json([
        "status" => "success",
        "message" => "Berhasil menambahkan kelas baru!",
      ]);
    } catch (\PDOException $e) {
      http_response_code($e->getCode());
      return self::json([
        "status" => "error",
        "message" => "Gagal menambahkan kelas baru, silahkan coba lagi!",
      ]);
    }
  }

  public function delete()
  {
    // validate method
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
      http_response_code(405);
      exit("Method not allowed");
    }

    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data["id"];

    try {
      Classes::delete($id);
      return self::json([
        "status" => "success",
        "message" => "Berhasil menghapus kelas!",
      ]);
    } catch (\PDOException $e) {
      http_response_code($e->getCode());
      return self::json([
        "status" => "error",
        "message" => "Gagal menghapus kelas, silahkan coba lagi!",
      ]);
    }
  }

  public function show($id)
  {
    return View::render("/classes/edit/index", [
      "title" => "Edit Kelas - AbsenQ",
      "titleHeader" => "Edit Kelas",
      "class" => Classes::find($id),
    ]);
  }

  public function update($id)
  {
    // validate method
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
      http_response_code(405);
      exit("Method not allowed");
    }

    $data = json_decode(file_get_contents("php://input"), true);

    // check is name already exists
    if (Classes::findByName($data["name"])) {
      http_response_code(400);
      return self::json([
        "status" => "error",
        "message" => "Kelas sudah ada!",
      ]);
    }

    try {
      Classes::update($id, $data);
      return self::json([
        "status" => "success",
        "message" => "Berhasil mengubah kelas!",
      ]);
    } catch (\PDOException $e) {
      http_response_code($e->getCode());
      return self::json([
        "status" => "error",
        "message" => "Gagal mengubah kelas, silahkan coba lagi!",
      ]);
    }
  }

}