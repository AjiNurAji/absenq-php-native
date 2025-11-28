<?php include __DIR__ . "/../layout/dashboard/top.php" ?>

<div class="rounded-lg border shadow-sm mb-6 bg-gradient-to-r from-blue-500 to-blue-500/80 border-0 text-white">
  <div class="px-6 py-8">
    <div class="text-center space-y-2">
      <div class="flex items-center justify-center gap-2 mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock-icon lucide-clock h-6 w-6">
          <path d="M12 6v6l4 2" />
          <circle cx="12" cy="12" r="10" />
        </svg>
        <span class="text-lg font-medium">Waktu Saat Ini</span>
      </div>
      <div class="text-5xl font-bold mb-2" id="timeDisplay"></div>
      <div class="flex items-center justify-center gap-2 text-lg opacity-90">
        <i class="h-5 w-5 fa-solid fa-calendar"></i>
        <span id="dateDisplay"></span>
      </div>
    </div>
  </div>
</div>

<div class="grid grid-template-columns-1 md:grid-cols-2 gap-6">
  <div class="rounded-lg border bg-white text-black shadow-sm">
    <div class="flex flex-col space-y-1.5 p-6">
      <h3 class="text-2xl font-semibold leading-none tracking-tight" id="status title">Absen Sekarang</h3>
    </div>
    <div class="p-6 pt-0">
      <div class="text-center py-4">
        <p>Mata kuliah: Matematika diskrit</p>
        <p class="text-2xl font-semibold text-green-500">
          Sudah Absen
        </p>
      </div>
    </div>
  </div>
  <div class="rounded-lg border bg-white text-black shadow-sm">
    <div class="flex flex-col space-y-1.5 p-6">
      <h3 class="text-2xl font-semibold leading-none tracking-tight" id="status title">Absen Mendatang</h3>
    </div>
    <div class="p-6 pt-0">
      <div class="text-center py-4">
        <p class="text-2xl font-semibold text-green-500">
        <p>Mata kuliah: Matematika diskrit</p>
        Belum Absen
        </p>
      </div>
    </div>
  </div>
</div>

<div class="rounded-lg border bg-white text-black shadow-sm mt-6">
  <div class="flex flex-col space-y-1.5 p-6 justify-center items-center">
    <!-- Qr Logo -->
    <div class="bg-blue-500/20 p-4 md:p-6 rounded-full mb-4">
      <div class="text-blue-600 text-xl md:text-2xl">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
          class="lucide lucide-qr-code-icon lucide-qr-code md:h-10 md:w-10 h-6 w-6">
          <rect width="5" height="5" x="3" y="3" rx="1" />
          <rect width="5" height="5" x="16" y="3" rx="1" />
          <rect width="5" height="5" x="3" y="16" rx="1" />
          <path d="M21 16h-3a2 2 0 0 0-2 2v3" />
          <path d="M21 21v.01" />
          <path d="M12 7v3a2 2 0 0 1-2 2H7" />
          <path d="M3 12h.01" />
          <path d="M12 3h.01" />
          <path d="M12 16v.01" />
          <path d="M16 12h1" />
          <path d="M21 12v.01" />
          <path d="M12 21v-1" />
        </svg>
      </div>
    </div>
    <div class="text-2xl font-semibold leading-none tracking-tight" id="status title">QR Code Absen</div>
  </div>
  <div class="p-6 pt-0">
    <div class="text-center py-4">
      <p>Mata kuliah: Matematika diskrit</p>
      <p>QR Code hanya berlaku 4 menit!</p>

      <!-- qr display -->
      <div class=""></div>

      <button
        type="submit"
        id="qr-generate"
        class="w-fit bg-blue-600 text-white py-3 rounded-lg text-lg font-semibold hover:bg-blue-700 transition duration-200 shadow-md disabled:opacity-50 disabled:cursor-not-allowed">
        Lihat QR Code
      </button>
    </div>
  </div>
</div>

<script>
  const timeDisplay = document.getElementById("timeDisplay");
  const dateDisplay = document.getElementById("dateDisplay");

  function time() {
    var d = new Date();

    timeDisplay.innerText = d.toLocaleTimeString("id-ID", {
      hour: "2-digit",
      minute: "2-digit",
      second: "2-digit",
    });
    dateDisplay.innerText = d.toLocaleDateString("id-ID", {
      weekday: "long",
      year: "numeric",
      month: "long",
      day: "numeric",
    });
  }

  setInterval(time, 1000);
</script>

<?php include __DIR__ . "/../layout/dashboard/bottom.php" ?>