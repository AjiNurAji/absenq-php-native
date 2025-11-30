<header class="flex justify-between items-center mb-8 bg-white p-4 rounded-lg shadow-sm">
  <div class="flex items-center gap-3">
    <div class="text-blue-600 text-xl">
      <i data-lucide="qr-code"></i>
    </div>
    <h1 class="text-xl font-bold text-gray-800 capitalize">
      <?= $titleHeader ?? ($auth["role"] === "admin" ? "Dashboard " . $auth["role"] : "Dashboard Mahasiswa") ?></h1>
  </div>
  <div class="flex items-center gap-3">
    <p>Halo, <?= $auth["name"] ?></p>
    <button id="hamburger-menu"
      class="flex md:hidden items-center gap-2 border border-gray-300 px-4 py-2 rounded-md text-gray-600 hover:bg-gray-50 text-sm font-medium transition">
      <i class="fa-solid fa-bars"></i>
    </button>
  </div>
</header>