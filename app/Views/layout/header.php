<?php
require __DIR__ . "/../lib/getAuth.php";
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?? "AbsenQ - Digital Attendance" ?></title>
  <!-- Integrasi Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Menggunakan Font Inter -->
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');

    body {
      font-family: 'Inter', sans-serif;
      background-color: #f7f9fc;
      /* Latar belakang sedikit off-white */
    }

    .card {
      background-color: white;
      border-radius: 8px;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
      padding: 24px;
    }

    * {
      scrollbar-width: thin;
      scrollbar-color: #e5e7eb transparent !important;
    }
  </style>
  <!-- lenis -->
  <link rel="stylesheet" href="https://unpkg.com/lenis@1.3.15/dist/lenis.css">
  <!-- font awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- toastify -->
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <!-- custom css -->
  <link rel="stylesheet" href="<?= getenv("APP_URL") . "/assets/css/style.css" ?>">
</head>

<body class="antialiased">