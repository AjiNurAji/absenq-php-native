<!-- SIDEBAR -->
<div id="backdrop" class="hidden md:hidden fixed w-full top-0 left-0 h-screen bg-zinc-800/25 backdrop-blur z-888"></div>
<aside id="sidebar"
  class="w-64 bg-white h-screen shadow-md fixed left-[-100%] justify z-999 md:!left-0 top-0 p-6 flex flex-col transition-all duration-300 ease-in-out">

  <h2 class="text-xl font-bold text-gray-800 mb-8">
    <i class="fa-solid fa-layer-group text-blue-600 mr-2"></i>
    <?= !is_array($auth) ? "Admin" : "User" ?> Panel
  </h2>

  <nav class="flex-1">
    <ul class="space-y-3">
      <li>
        <a href="/dashboard" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 text-gray-700">
          <i class="fa-solid fa-gauge"></i>
          Dashboard
        </a>
      </li>

      <?php
      if ($auth && !is_array($auth)) {
        include __DIR__ . "/admin/sidebar.php";
      } else {
        include __DIR__ . "/student/sidebar.php";
      }

      ?>

    </ul>
  </nav>

  <!-- Logout -->
  <form action="/logout" id="logout-form" method="POST">
    <button type="submit" id="button-logout"
      class="w-full bg-red-600 text-white py-2 rounded-lg text-lg font-semibold hover:bg-red-700 transition duration-200 shadow-md mt-6">
      <i class="fa-solid fa-right-from-bracket mr-2"></i>
      Logout
    </button>
  </form>
  <button id="close-sidebar"
    class="bg-blue-600 text-white p-2 rounded-full rounded-lg text-lg font-semibold hover:bg-blue-700 transition duration-200 shadow-md absolute top-4 -right-4 md:hidden">
    <i class="fa-solid fa-close"></i>
  </button>
</aside>

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