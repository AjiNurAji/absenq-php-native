<!-- SIDEBAR -->
<div id="backdrop" class="hidden lg:hidden fixed w-full top-0 left-0 h-screen bg-zinc-800/25 backdrop-blur z-888"></div>
<aside id="sidebar"
  class="w-64 bg-white h-screen shadow-md fixed left-[-100%] justify z-999 lg:!left-0 top-0 p-6 flex flex-col transition-all duration-300 ease-in-out">

  <h2 class="text-xl font-bold text-gray-800 mb-8">
    <i class="fa-solid fa-layer-group text-blue-600 mr-2"></i>
    <?= $auth["role"] === "admin" ? "Admin" : "User" ?> Panel
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
      if ($auth["role"] === "admin") {
        include __DIR__ . "/admin/sidebar.php";
      } else {
        include __DIR__ . "/student/sidebar.php";
      }

      ?>

    </ul>
  </nav>

  <button id="close-sidebar"
    class="bg-blue-600 text-white p-2 rounded-full rounded-lg text-lg font-semibold hover:bg-blue-700 transition duration-200 shadow-md absolute top-4 -right-4 lg:hidden">
    <i class="fa-solid fa-close"></i>
  </button>
</aside>