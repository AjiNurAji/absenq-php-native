<?php
use App\Controllers\AttendanceController;
use App\Controllers\StudentController;
use App\Core\Router;
use App\Middlewares\AuthMiddleware;

Router::post("/student/qr-image", [StudentController::class, "qrImage"], [
  [AuthMiddleware::class, "student"]
]);

Router::get("/student/qr", [StudentController::class, "qr"], [
  [AuthMiddleware::class, "student"]
]);

Router::get("/attendances", [AttendanceController::class, "index"], [
  [AuthMiddleware::class, "admin"]
]);

Router::get("/student/attendance", [AttendanceController::class, "hisotyStudent"], [
  [AuthMiddleware::class, "student"]
]);

Router::get("/attendance/chart/weekly", [AttendanceController::class, "chartWeekly"], [
  [AuthMiddleware::class, "admin"]
]);

Router::get("/attendance/chart/monthly", [AttendanceController::class, "chartMonthly"], [
  [AuthMiddleware::class, "admin"]
]);

Router::get("/scan", [AttendanceController::class, "scanPage"], [
  [AuthMiddleware::class, "admin"]
]);

Router::post(
  "/scan/submit",
  [AttendanceController::class, "scanSubmit"],
  [
    [AuthMiddleware::class, "admin"]
  ]
);

Router::get("/student/schedule/{schedule_id}/absent", [AttendanceController::class, "absent"], [
  [AuthMiddleware::class, "student"]
]);

Router::post("/student/schedule/absent", [AttendanceController::class, "absentPost"], [
  [AuthMiddleware::class, "student"]
]);

Router::get("/attendance/success", [AttendanceController::class, "successAttendance"], [
  [AuthMiddleware::class, "student"]
]);

Router::post("/attendance/checking", [StudentController::class, "checkAttendance"], [
  [AuthMiddleware::class, "student"]
]);