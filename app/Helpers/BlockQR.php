<?php

namespace App\Helpers;

class BlockQR
{
  private static string $file = __DIR__ . "/../../storage/qr/used.log";

  public static function isUsed(string $qr_id): bool
  {
    if (!file_exists(self::$file)) {
      return false;
    }

    $line = file(self::$file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    return in_array($qr_id, $line);
  }

  public static function markUsed(string $qr_id)
  {
    self::clearDaily();
    file_put_contents(self::$file, $qr_id . PHP_EOL, FILE_APPEND);
  }

  public static function clearDaily(): void
  {
    $today = date("Y-m-d");
    $flag = __DIR__ . '/../../storage/qr/qr_last_clear.txt';

    // cek apakah sudah clear hari ini
    if (file_exists($flag)) {
      $last = trim(file_get_contents($flag));
      if ($last === $today)
        return;
    }

    // reset file
    file_put_contents(self::$file, "");
    file_put_contents($flag, $today);
  }
}