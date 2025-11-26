<?php

namespace App\Core;

class View
{
  public static function render(string $view, array $data = [])
  {
    $viewPath = __DIR__ . "/../Views/" . str_replace(".", "/", $view) . ".php";

    if (!file_exists($viewPath)) {
      throw new \Exception("View file not found: " . $viewPath);
    }

    extract($data);
    require $viewPath;
  }
}