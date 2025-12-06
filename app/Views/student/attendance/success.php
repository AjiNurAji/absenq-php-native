<?php include __DIR__ . "/../../layout/header.php"; ?>
<div class="min-h-screen bg-gradient-to-br from-white via-white to-green-500/5 flex flex-col">
  <div class="flex-1 flex items-center justify-center p-4">
    <div class="w-full max-w-md space-y-6">
      <div class="shadow-2xl border border-green-600/20 bg-white overflow-hidden rounded-lg">
        <div class="h-2 bg-gradient-to-r from-green-600 via-green-600/80 to-green-600"></div>
        <div class="py-8 px-6">
          <div class="text-center space-y-6">
            <div class="relative mx-auto w-fit">
              <div class="absolute inset-0 bg-green-600/20 rounded-full animate-ping"></div>
              <div
                class="relative h-28 w-28 rounded-full bg-gradient-to-br from-green-600 to-green-600/80 flex items-center justify-center shadow-lg shadow-green-600/30 animate-in zoom-in duration-500">
                <i data-lucide="check-circle" class="h-14 w-14 text-white"></i>
              </div>
            </div>
            <div class="space-y-2">
              <?php if ($lastAttendance->status === "absent"): ?>
                <h1 class="text-2xl font-bold text-foreground">
                  Izin Tidak Hadir
                </h1>
              <?php else: ?>
                <h1 class="text-2xl font-bold text-foreground">
                  Absen <?= htmlspecialchars(!$lastAttendance->out_time ? "Masuk" : "Pulang") ?>
                </h1>
              <?php endif; ?>
              <p class="text-gray-500">
                Absensi Anda telah berhasil tercatat
              </p>
            </div>

            <div class="bg-gray-400/10 rounded-xl p-6 space-y-4 text-left">
              <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-full bg-blue-500/10 flex items-center justify-center">
                  <i data-lucide="clock" class="h-6 w-6 text-blue-500"></i>
                </div>
                <div>
                  <p class="text-sm text-gray-500">Waktu</p>
                  <p class="text-xl font-bold text-foreground">
                    <?= htmlspecialchars(date("H:m", !$lastAttendance->out_time ? $lastAttendance->in_time : $lastAttendance->out_time)) ?>
                  </p>
                </div>
              </div>
              <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-full bg-blue-500/10 flex items-center justify-center">
                  <i data-lucide="calendar" class="h-6 w-6 text-blue-500"></i>
                </div>
                <div>
                  <p class="text-sm text-gray-500">Tanggal</p>
                  <p class="text-base font-medium text-foreground">
                    <?= htmlspecialchars(date("l, d-m-Y", !$lastAttendance->out_time ? $lastAttendance->in_time : $lastAttendance->out_time)) ?>
                  </p>
                </div>
              </div>
              <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-full bg-blue-500/10 flex items-center justify-center">
                  <i data-lucide="map-pin" class="h-6 w-6 text-blue-500"></i>
                </div>
                <div>
                  <p class="text-sm text-gray-500">Lokasi</p>
                  <p class="text-base font-medium text-foreground">
                    <?= $lastAttendance->status === "absent" ? "Luar Kampus" : "STMIK IKMI Cirebon" ?>
                  </p>
                </div>
              </div>
            </div>

            <?php if ($lastAttendance->status === "absent"): ?>
              <div class="inline-flex items-center gap-2 px-4 py-2 bg-green-600/10 rounded-full">
                <div class="h-2 w-2 bg-green-600 rounded-full animate-pulse"></div>
                <span class="text-sm font-medium text-green-600">
                  Izin Tidak Hadir
                </span>
              </div>
            <?php else: ?>
              <div class="inline-flex items-center gap-2 px-4 py-2 bg-green-600/10 rounded-full">
                <div class="h-2 w-2 bg-green-600 rounded-full animate-pulse"></div>
                <span class="text-sm font-medium text-green-600">
                  <?= htmlspecialchars(!$lastAttendance->out_time ? "Absen Masuk" : "Absen Pulang") ?>
                </span>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <div class="text-center">
        <p class="text-sm">Halaman ini akan otomatis pindah dalam: <span id="countdown"></span> detik.</p>
        <p class="text-xs italic">jika tidak terpindahkan silahkan <a class="underline text-blue-500"
            href="/dashboard">klik disini</a>.</p>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . "/../../layout/footer.php"; ?>

<!-- countdown 10 seconds -->
<script>
  const countdownEl = document.getElementById("countdown");

  function countDown() {
    let count = 10;

    const interval = setInterval(() => {
      if (count <= 0) {
        clearInterval(interval);
        localStorage.clear();
        window.location.href = "/dashboard";
        return;
      };

      count--;

      countdownEl.innerText = count;
    }, 1000);
  }

  countDown()
</script>