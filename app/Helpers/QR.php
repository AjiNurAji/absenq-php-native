<?php

namespace App\Helpers;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\Font\OpenSans;
use Endroid\QrCode\Label\LabelAlignment;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
class QR
{
  public static function generate(string $payload, string $student_name)
  {
    return new Builder(
    writer: new PngWriter(),
    writerOptions: [],
    validateResult: false,
    data: $payload,
    encoding: new Encoding('UTF-8'),
    errorCorrectionLevel: ErrorCorrectionLevel::High,
    size: 300,
    margin: 10,
    roundBlockSizeMode: RoundBlockSizeMode::Margin,
    // logoPath: __DIR__ . '/assets/bender.png',
    // logoResizeToWidth: 50,
    // logoPunchoutBackground: true,
    labelText: "QR Absen: " . $student_name,
    labelFont: new OpenSans(15),
    labelAlignment: LabelAlignment::Center
    )->build();
  }
}