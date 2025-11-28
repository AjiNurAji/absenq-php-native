<header class="flex justify-between items-center mb-8 bg-white p-4 rounded-lg shadow-sm">
  <div class="flex items-center gap-3">
    <div class="text-blue-600 text-xl">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
        class="lucide lucide-qr-code-icon lucide-qr-code">
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
    <h1 class="text-xl font-bold text-gray-800">Dashboard <?= !is_array($auth) ? "Admin" : "User" ?></h1>
  </div>
  <div class="flex items-center gap-3">
    <p>Halo, <?= !is_array($auth) ? $auth : $auth["student_id"]["name"] ?></p>
    <button id="hamburger-menu"
      class="flex md:hidden items-center gap-2 border border-gray-300 px-4 py-2 rounded-md text-gray-600 hover:bg-gray-50 text-sm font-medium transition">
      <i class="fa-solid fa-bars"></i>
    </button>
  </div>
</header>