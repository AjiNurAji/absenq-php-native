<?php
use App\Controllers\AttendanceController;
use App\Controllers\StudentController;
use App\Core\Router;

Router::get('/student/qr', [StudentController::class, 'qr']);
Router::get('/student/qr-image', [StudentController::class, 'qrImage']);

Router::get('/scan', [AttendanceController::class, 'scanPage']);
Router::post('/scan/submit', [AttendanceController::class, 'scanSubmit']);