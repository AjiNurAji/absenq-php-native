<style>
  button {
    background-color: oklch(54.6% 0.245 262.881) !important;
    color: white !important;
    padding: 5px 10px !important;
    border-radius: 5px;
    margin-bottom: 15px !important;
  }

  button:hover {
    background-color: oklch(46.6% 0.245 262.881) !important;
  }
</style>

<?php include __DIR__ . "/../../layout/header.php"; ?>
<div class="container mx-auto p-4">
  <a href="/schedules" class="mb-4 text-white bg-red-600 px-4 py-2 w-fit block text-base rounded-lg">Kembali</a>

  <div class="flex flex-wrap items-start gap-4">
    <div class="bg-white shadow rounded p-4">
      <h2 class="text-xl font-medium mb-4">Scan QR</h2>
      <div class="w-full md:w-[400px] h-auto max-h-[500px] rounded-xl overflow-hidden">
        <div id="reader" class="w-full h-full"></div>
      </div>
    </div>
    <div class="flex flex-col gap-4 flex-1 w-full">
      <div class="bg-white shadow flex-1 rounded p-4 w-full">
        <h2 class="text-xl font-medium mb-4">Informasi Mahasiswa</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="bg-blue-300/10 rounded-lg text-start p-3">
            <h3 class="text-lg font-medium">NIM</h3>
            <p id="id_number_display">-</p>
          </div>
          <div class="bg-blue-300/10 rounded-lg text-start p-3">
            <h3 class="text-lg font-medium">Nama Lengkap</h3>
            <p id="name_display">-</p>
          </div>
        </div>
      </div>
      <div class="bg-white shadow flex-1 rounded p-4 w-full">
        <h2 class="text-xl font-medium mb-4">Informasi Jadwal</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="bg-blue-300/10 rounded-lg text-start p-3">
            <h3 class="text-lg font-medium">Mata Kuliah</h3>
            <p><?= htmlspecialchars($schedule->course_name) ?></p>
          </div>
          <div class="bg-blue-300/10 rounded-lg text-start p-3">
            <h3 class="text-lg font-medium">Kelas</h3>
            <p><?= htmlspecialchars($schedule->class_name) ?></p>
          </div>
          <div class="bg-blue-300/10 rounded-lg text-start p-3">
            <h3 class="text-lg font-medium">Masuk</h3>
            <p><?= htmlspecialchars($schedule->date . ", " . $schedule->start_time) ?></p>
          </div>
          <div class="bg-blue-300/10 rounded-lg text-start p-3">
            <h3 class="text-lg font-medium">Keluar</h3>
            <p><?= htmlspecialchars($schedule->date . ", " . $schedule->end_time) ?></p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include __DIR__ . "/../../layout/footerByAji.php" ?>
</div>

<script src="https://unpkg.com/html5-qrcode"></script>

<?php include __DIR__ . "/../../layout/footer.php"; ?>

<script>
  const displayId = document.getElementById("id_number_display");
  const displayName = document.getElementById("name_display");
  let isLocked = false;

  async function onScanSuccess(decodedText) {
    if (isLocked) return;
    isLocked = true;
    Toastify({
      text: "Mohon tunggu...",
      duration: 3000,
      backgroundColor: "linear-gradient(to right, #004cb0ff, #3d69c9ff)",
    }).showToast();

    const res = await fetch("/scan/submit", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ qr: decodedText, schedule_id: <?= $schedule->id ?> })
    });

    const result = await res.json();

    if (res.ok) {
      Toastify({
        text: result.message,
        duration: 3000,
        backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
      }).showToast();
      displayId.innerText = result.student.student_id
      displayName.innerText = result.student.name
      setTimeout(() => isLocked = false, 1000)
    } else {
      Toastify({
        text: result.message,
        duration: 3000,
        backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
      }).showToast();
        setTimeout(() => isLocked = false, 1000)
    }
  }

  let html5QrcodeScanner = new Html5QrcodeScanner(
    "reader",
    { fps: 10, qrbox: 250 }
  );

  html5QrcodeScanner.render(onScanSuccess);
</script>