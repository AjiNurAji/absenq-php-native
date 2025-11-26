<?php

namespace App\Core;

class Env
{
  public static function load(string $filePath): void
  {
    if (!file_exists($filePath)) {
      throw new \Exception("Env file not found: " . $filePath);
    }

    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
      # Skip comments
      if (str_starts_with(trim($line), "#")) {
        continue;
      }

      // Split by the first '=' character
      if (!str_contains($line, "=")) {
        continue;
      }

      list($key, $value) = explode("=", $line, 2);

      // Trim whitespace and remove surrounding quotes
      $key = trim($key);
      $value = trim($value);

      // Remove surrounding quotes if present
      $value = trim($value, "\"'");

      // Set the environment variable
      $_ENV[$key] = $value;
      $_SERVER[$key] = $value;
      putenv("$key=$value");
    }
  }

  public static function get(string $key, $default = null)
  {
    return $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key) ?: $default;
  }
}
