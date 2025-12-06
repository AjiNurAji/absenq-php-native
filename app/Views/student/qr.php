<?php include __DIR__ . "/../layout/header.php"; ?>
<div class="min-h-screen bg-gradient-to-br from-white via-white to-green-500/5 flex flex-col">
  <header class="border-b bg-white/50 backdrop-blur-sm sticky top-0 z-10">
    <div class="container mx-auto px-4 py-4">
      <a href="/dashboard"
        class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 h-9 rounded-md px-3 hover:bg-red-600 hover:text-white">
        <i data-lucide="arrow-left" class="h-4 w-4 mr-2"></i>
        Kembali
      </a>
    </div>
  </header>
  <div class="container mx-auto p-4">
    <div class="mx-auto rounded-lg border bg-white text-black shadow-sm w-full max-w-[400px]">
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

          <!-- qr display -->
          <div class="w-full hidden" id="qr-wrapper">
            <p class="text-xs text-center mb-2">Kedaluwarsa dalam: <span id="countdown"></span> </p>
            <div class="rounded-md max-w-[400px] mx-auto">
              <img src="" alt="QR Code" class="w-full h-auto object-cover" id="qr-image" />
            </div>
          </div>

          <button type="submit" id="qr-generate"
            class="w-fit bg-blue-600 text-white px-3 py-1 mt-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition duration-200 shadow-md disabled:opacity-50 disabled:cursor-not-allowed">
            Dapatkan QR Code
          </button>
        </div>
      </div>
    </div>
    <?php include __DIR__ . "/../layout/footerByAji.php" ?>
  </div>
  <?php include __DIR__ . "/../layout/footer.php"; ?>
</div>

<script>
  const buttonGetQR = document.getElementById("qr-generate");
  const qrImage = document.getElementById("qr-image");
  const qrWrapper = document.getElementById("qr-wrapper");

  buttonGetQR.addEventListener("click", async (e) => {
    e.preventDefault();

    e.target.disabled = true;
    Toastify({
      text: "Mohon tunggu...",
      duration: 3000,
      backgroundColor: "linear-gradient(to right, #004cb0ff, #3d69c9ff)",
    }).showToast();

    const res = await fetch("/student/qr-image", {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      }
    });

    const result = await res.json();

    if (res.ok) {
      Toastify({
        text: result.message,
        duration: 3000,
        backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
      }).showToast();

      localStorage.setItem("qr-code", JSON.stringify(result.qr_code));
      qrWrapper.classList.remove("hidden");
      e.target.disabled = true;
      e.target.classList.add("hidden");
      qrImage.src = result.qr_code.qr_image;

      startCountdown(result.qr_code.exp);
    } else {
      e.target.disabled = false;
      Toastify({
        text: result.message,
        duration: 3000,
        backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
      }).showToast();
    }
  });


  function startCountdown(expires_at) {
    const countdownEl = document.getElementById("countdown");
    let remaining = expires_at * 1000;

    const interval = setInterval(() => {
      const now = Date.now();
      let diff = Math.floor((remaining - now) / 1000);

      if (diff <= 0) {
        clearInterval(interval);
        localStorage.removeItem("qr-code");
        localStorage.removeItem("last_remaining");
        qrWrapper.classList.add("hidden");
        buttonGetQR.classList.remove("hidden");
        buttonGetQR.disabled = false;
        return;
      }

      const mins = Math.floor(diff / 60);
      const secs = diff % 60;

      countdownEl.innerText = `${mins}:${secs.toString().padStart(2, '0')}`;
      checkAttendance();
    }, 1000);
  }
</script>
<script>
  let locked = false;
  async function checkAttendance() {
    if (locked) return;
    lokced = true;

    await fetch("/attendance/checking", {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify({ schedule_id: <?= $upcomingAttendance->id ?> })
    }).then(res => res.json()).then(res => {
      if (!res.checking) return lokced = false;
      if (!res.checking.out_time) return locked = false;

      if (res.checking.in_time) {
        Toastify({
          text: res.message + " pulang",
          duration: 3000,
          backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
        }).showToast();
        window.location.href = "/attendance/success";
        lokced = false;
        return;
      } else {
        Toastify({
          text: res.message + " masuk",
          duration: 3000,
          backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
        }).showToast();
        lokced = false;
        window.location.href = "/attendance/success";
      }
    });
  }
</script>
<script>
  // check localstorage
  function checkLocalStorage() {
    const qr = JSON.parse(localStorage.getItem("qr-code"));
    if (!qr) return;

    qrWrapper.classList.remove("hidden");
    buttonGetQR.disabled = true;
    buttonGetQR.classList.add("hidden");
    qrImage.src = qr.qr_image;
    startCountdown(qr.exp);
    return;
  }

  checkLocalStorage();
</script>