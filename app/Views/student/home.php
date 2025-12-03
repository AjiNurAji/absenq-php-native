<?php include __DIR__ . "/../layout/dashboard/top.php" ?>

<div class="rounded-lg border shadow-sm mb-6 bg-gradient-to-r from-blue-500 to-blue-500/80 border-0 text-white">
  <div class="px-6 py-8">
    <div class="text-center space-y-2">
      <div class="flex items-center justify-center gap-2 mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
          class="lucide lucide-clock-icon lucide-clock h-6 w-6">
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
      <h3 class="text-2xl font-semibold leading-none tracking-tight" id="status title">Absen Terakhir</h3>
    </div>
    <div class="p-6 pt-0">
      <div class="text-center py-4">
        <?php if (!$lastAttendance): ?>
          <p class="text-2xl font-semibold text-red-500">
            Belum Absen
          </p>

        <?php else: ?>
          <p>Mata kuliah: <?= htmlspecialchars($lastAttendance->course_name) ?></p>
          <p class="text-2xl font-semibold text-green-500">
            Absen <?= htmlspecialchars($lastAttendance->type === "in" ? "Masuk" : "Pulang") ?>
          </p>
          <p class="text-sm"><?= htmlspecialchars(date("H:m", strtotime($lastAttendance->time))) ?></p>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <div class="rounded-lg border bg-white text-black shadow-sm">
    <div class="flex flex-col space-y-1.5 p-6">
      <h3 class="text-2xl font-semibold leading-none tracking-tight" id="status title">Absen Mendatang</h3>
    </div>
    <div class="p-6 pt-0">
      <div class="text-center py-4">
        <?php if (!$upcomingAttendance): ?>
          <p class="text-2xl font-semibold text-red-500">
            Tidak ada jadwal
          </p>

        <?php else: ?>
          <p>Mata kuliah: <?= htmlspecialchars($upcomingAttendance->course_name) ?></p>
          <p>Tanggal/waktu:
            <?= htmlspecialchars($upcomingAttendance->date . "/" . $upcomingAttendance->start_time . " s/d " . $upcomingAttendance->end_time) ?>
          </p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<div class="rounded-lg border bg-white text-black shadow-sm mt-6">
  <div class="flex flex-col space-y-1.5 p-6 justify-center items-center">
    <!-- Qr Logo -->
    <div class="bg-blue-500/20 p-4 md:p-6 rounded-full mb-4">
      <div class="text-blue-600 text-xl md:text-2xl">
        <i data-lucide="qr-code" class="size-8"></i>
      </div>
    </div>
    <div class="text-2xl font-semibold leading-none tracking-tight" id="status title">QR Code Absen</div>
  </div>
  <div class="p-6 pt-0">
    <div class="text-center py-4">
      <p>QR Code hanya berlaku 4 menit!</p>

      <a href="/student/qr"
        class="w-fit bg-blue-600 inline-block text-white px-3 py-1 mt-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition duration-200 shadow-md disabled:opacity-50 disabled:cursor-not-allowed">
        Lihat QR Code
        </a>
    </div>
  </div>
</div>

<?php include __DIR__ . "/../layout/footerByIndah.php" ?>

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