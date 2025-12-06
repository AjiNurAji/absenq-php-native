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

  #reader video {
    width: 100% !important;
  }
</style>

<?php include __DIR__ . "/../../layout/header.php"; ?>
<div class="min-h-screen bg-gradient-to-br from-white via-white to-green-500/5 flex flex-col">
  <header class="border-b bg-white/50 backdrop-blur-sm sticky top-0 z-10">
    <div class="container mx-auto px-4 py-4">
      <a href="/schedules"
        class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 h-9 rounded-md px-3 hover:bg-red-600 hover:text-white">
        <i data-lucide="arrow-left" class="h-4 w-4 mr-2"></i>
        Kembali
      </a>
    </div>
  </header>
  <div class="container mx-auto p-4">
    <div class="flex flex-wrap items-start gap-4">
      <div class="bg-white shadow rounded p-4">
        <h2 class="text-xl font-medium mb-4">Scan QR</h2>
        <div class="w-full max-w-full md:w-[400px] h-auto rounded-xl overflow-hidden">
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

  // let html5QrcodeScanner = new Html5QrcodeScanner(
  //   "reader",
  //   {
  //     fps: 10, qrbox: 250, 
  //     // videoConstraints: {
  //     //   facingMode: { exact: "environment" },
  //     // },
  //   }
  // );

  // html5QrcodeScanner.render(onScanSuccess);
  Html5Qrcode.getCameras().then(devices => {
    if (devices && devices.length) {
      let backCamera = devices.find(d => d.label.toLowerCase().includes("back"));
      let cameraId = backCamera ? backCamera.id : devices[0].id;

      const html5QrCode = new Html5Qrcode("reader");

      html5QrCode.start(
        cameraId,
        {
          fps: 10,
          qrbox: 250
        },
        onScanSuccess
      )
    }
  })
</script>