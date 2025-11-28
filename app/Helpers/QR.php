<?php

namespace App\Helpers;

use Endroid\QrCode\Builder\Builder;

class QR
{
  public static function generate($student_id, $schedule_id)
  {
    $content = "{$student_id}|{$schedule_id}";

    $qr = Builder::create()
      ->data($content)
      ->size(300)
      ->margin(10)
      ->build();

    return $qr->getString(); // base64 PNG
  }
}
