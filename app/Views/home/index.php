<?php include __DIR__ . "/../layout/header.php" ?>


<!-- Langkah 2: Navbar (Header) -->
<header class="sticky top-0 bg-white shadow-sm z-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
    <!-- Logo -->
    <a href="#" class="text-xl font-bold text-gray-800">AbsenQ</a>

    <!-- Tombol Login -->
    <a href="<?= $auth ? "/dashboard" :  "/login"  ?>" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-full transition duration-300 shadow-md">
      <?= $auth ? "Dashboard" :  "Login"  ?>
    </a>
  </div>
</header>

<!-- Langkah 3: Main Content -->
<main>

  <!-- Hero Section -->
  <section id="hero" class="text-center pt-20 pb-16 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 h-screen">
    <h1 class="text-5xl md:text-6xl font-extrabold text-gray-900 leading-tight mb-4">
      Sistem Absensi Online
    </h1>
    <h2 class="text-5xl md:text-6xl font-extrabold text-blue-600 leading-tight mb-6">
      Modern & Efisien
    </h2>
    <p class="text-xl text-gray-600 mb-10 max-w-3xl mx-auto">
      Kelola kehadiran mahasiswa dengan mudah menggunakan teknologi QR Code. Cepat, akurat, dan real-time.
    </p>

    <!-- Tombol Aksi -->
    <div class="flex justify-center space-x-4">
      <a href="<?= $auth ? "/dashboard" :  "/login"  ?>" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg shadow-lg transition duration-300 transform hover:scale-105">
        Mulai Sekarang
      </a>
      <a href="https://github.com/ajinuraji/absenq" target="_blank" class="bg-white text-blue-600 border border-blue-600 hover:bg-blue-50 font-semibold py-3 px-8 rounded-lg transition duration-300">
        Pelajari Lebih Lanjut
      </a>
    </div>
  </section>

  <!-- Feature Section -->
  <section class="py-20 bg-white" id="features">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <h3 class="text-3xl font-bold text-gray-800 mb-3">Fitur Unggulan</h3>
      <p class="text-gray-500 mb-12">Sistem absensi yang lengkap untuk kebutuhan perusahaan atau sekolah</p>

      <!-- Grid Kartu Fitur (Responsive) -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

        <!-- Kartu 1: Absensi QR Code -->
        <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition duration-300 border-t-4 border-blue-500 card">
          <!-- Icon QR Code (menggunakan SVG sederhana) -->
          <div class="text-blue-500 mb-4 mx-auto w-12 h-12">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.5h16.5m-16.5 12h16.5M21.75 6.75v10.5a1.5 1.5 0 0 1-1.5 1.5h-15a1.5 1.5 0 0 1-1.5-1.5V6.75a1.5 1.5 0 0 1 1.5-1.5h15a1.5 1.5 0 0 1 1.5 1.5Z" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6M15 12h-6" />
            </svg>
          </div>
          <h4 class="text-xl font-semibold text-gray-800 mb-2">Absensi QR Code</h4>
          <p class="text-gray-500 text-sm">Gunakan QR code untuk check-in dan check-out dengan cepat dan mudah.</p>
        </div>

        <!-- Kartu 2: Riwayat Kehadiran -->
        <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition duration-300 border-t-4 border-blue-500 card">
          <!-- Icon Riwayat (menggunakan SVG sederhana) -->
          <div class="text-blue-500 mb-4 mx-auto w-12 h-12">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
          </div>
          <h4 class="text-xl font-semibold text-gray-800 mb-2">Riwayat Kehadiran</h4>
          <p class="text-gray-500 text-sm">Lihat riwayat absensi lengkap dengan waktu masuk dan keluar.</p>
        </div>

        <!-- Kartu 3: Dashboard Admin -->
        <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition duration-300 border-t-4 border-blue-500 card">
          <!-- Icon Dashboard (menggunakan SVG sederhana) -->
          <div class="text-blue-500 mb-4 mx-auto w-12 h-12">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125l7.5 7.5 7.5-7.5m-15 0l7.5-7.5 7.5 7.5" />
            </svg>
          </div>
          <h4 class="text-xl font-semibold text-gray-800 mb-2">Dashboard Admin</h4>
          <p class="text-gray-500 text-sm">Monitor kehadiran karyawan secara real-time dengan visualisasi data.</p>
        </div>

        <!-- Kartu 4: Otomatis & Akurat -->
        <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition duration-300 border-t-4 border-blue-500 card">
          <!-- Icon Akurat (menggunakan SVG sederhana) -->
          <div class="text-blue-500 mb-4 mx-auto w-12 h-12">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
          </div>
          <h4 class="text-xl font-semibold text-gray-800 mb-2">Otomatis & Akurat</h4>
          <p class="text-gray-500 text-sm">Sistem otomatis menghitung jam kerja dengan akurat dan menghitung jam kerja.</p>
        </div>

      </div>
    </div>
  </section>

  <!-- Call to Action (CTA) Section -->
  <section class="py-20 bg-blue-600">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
      <h3 class="text-3xl md:text-4xl font-bold mb-4">Siap untuk memulai?</h3>
      <p class="text-lg mb-8">Daftar sekarang dan rasakan kemudahan sistem absensi digital.</p>

      <!-- Tombol CTA -->
      <a href="<?= $auth ? "/dashboard" :  "/login"  ?>" class="bg-white text-blue-600 hover:bg-gray-100 font-bold py-3 px-10 rounded-lg shadow-xl transition duration-300 transform hover:scale-105">
        <?= $auth ? "Pergi ke Dashboard" :  "Login Sekarang"  ?>
      </a>
    </div>
  </section>

</main>

<!-- Langkah 4: Footer -->
<footer class="flex md:flex-row flex-col w-full justify-center md:justify-between px-4 align-center py-6 text-center bg-gray-50">
  <p class="text-sm text-gray-500">Slicing by - Indah Suci Ramadani</p>
  <p class="text-sm text-gray-500">© 2025 AbsenQ. All rights reserved.</p>
</footer>

<?php include __DIR__ . "/../layout/footer.php" ?>