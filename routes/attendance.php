<?php
use App\Controllers\AttendanceController;
use App\Controllers\StudentController;
use App\Core\Router;
use App\Middlewares\AuthMiddleware;

Router::get('/student/qr', [StudentController::class, 'qr'],[
  [AuthMiddleware::class, "student"]
]);
Router::get('/student/qr-image', [StudentController::class, 'qrImage'],[
  [AuthMiddleware::class, "student"]
]);

Router::get('/scan', [AttendanceController::class, 'scanPage'], [
  [AuthMiddleware::class, "admin"]
]);
Router::post('/scan/submit', [AttendanceController::class, 'scanSubmit']);