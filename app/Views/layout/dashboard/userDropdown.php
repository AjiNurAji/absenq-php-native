<div class="relative w-full">
  <button id="trigger-profile"
    class="flex items-center gap-1 bg-transparent rounded-md overflow-hidden py-1 px-2 hover:bg-gray-500/5 transition duration-300 ease-in outline-none">
    <div class="size-10 flex justify-center items-center text-xl bg-green-500/15 rounded-full block">
      <?= htmlspecialchars(strtoupper($auth["name"][0])) ?>
    </div>
    <i data-lucide="chevron-up" id="arrow" class="size-4 rotate-180 transition duration-300 ease-linear"></i>
  </button>
  <div id="popover-profile"
    class="bg-white transition mt-2 duration-300 ease-in absolute p-3 hidden scale-x-0 -bottom-110 w-[350px] z-999 right-0 shadow rounded-lg">
    <div class="border-b border-gray-500/10 mb-3">
      <span class="text-sm font-bold mb-2"><?= $auth["role"] === "admin" ? "Username" : "Nama Lengkap" ?></span>
      <p class="text-lg"><?= $auth["name"] ?></p>
    </div>
    <form action="/logout" id="logout-form" method="POST">
      <button type="submit" id="button-logout"
        class="w-full inline-block bg-red-600 text-white py-2 rounded-lg text-lg font-semibold hover:bg-red-700 transition duration-200 shadow-md">
        <i class="fa-solid fa-right-from-bracket mr-2"></i>
        Logout
      </button>
    </form>
  </div>
</div>

<!-- scipt logout -->
<script>
  const logoutForm = document.getElementById("logout-form");
  const buttonLogout = document.getElementById("button-logout");

  logoutForm.addEventListener("submit", async (e) => {
    e.preventDefault();
    buttonLogout.disabled = true;
    buttonLogout.innerText = "Memproses...";

    const response = await fetch("/logout", {
      method: "POST",
    });

    if (response.redirected) {
      Toastify({
        text: "Logout berhasil",
        duration: 3000,
        backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
      }).showToast();

      window.location.href = "/login";
      localStorage.clear();

      buttonLogout.disabled = false;
      buttonLogout.innerText = "Logout";
    } else {
      buttonLogout.disabled = false;
      buttonLogout.innerText = "Logout";

      Toastify({
        text: "Terjadi kesalahan saat logout",
        duration: 3000,
        backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
      }).showToast();
    }
  });
</script>

<!-- handle profile -->
<script>
  const triggerButton = document.getElementById("trigger-profile");
  const popoverProfile = document.getElementById("popover-profile");
  
  triggerButton.addEventListener("click", (e) => {
    e.preventDefault();
    const arrowEl = document.getElementById("arrow");

    arrowEl.classList.toggle("rotate-0");
    popoverProfile.classList.toggle("hidden");
    popoverProfile.classList.toggle("scale-x-0");
    popoverProfile.classList.toggle("scale-x-1");
    return;
  });
</script>