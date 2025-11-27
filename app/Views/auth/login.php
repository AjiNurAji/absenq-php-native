<?php include __DIR__ . "/../layout/header.php" ?>

<main class="bg-gray-100 flex flex-col items-center justify-center h-screen">

  <div class="bg-white p-10 rounded-2xl shadow-xl w-full max-w-md text-center">

    <div class="flex justify-center mb-4">
      <div class="bg-blue-100 p-3 rounded-xl border border-blue-200">
        <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <rect x="5" y="5" width="4" height="4" />
          <rect x="5" y="15" width="4" height="4" />
          <rect x="15" y="5" width="4" height="4" />
          <rect x="15" y="15" width="4" height="4" />
          <rect x="10" y="10" width="4" height="4" />
        </svg>
      </div>
    </div>

    <h1 class="text-2xl font-bold mb-1">AbsenQ</h1>
    <p class="text-gray-600 mb-8">Masuk ke akun Anda untuk melanjutkan</p>

    <form action="login.php" id="login-form" method="POST" class="text-left">

      <label class="block text-sm font-medium text-gray-700 mb-1">Username/NIM</label>
      <input
        type="text"
        name="username"
        class="w-full p-3 border border-gray-300 rounded-lg mb-4 placeholder:text-gray-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
        placeholder="Masukkan Username/NIM" required />

      <label class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi</label>
      <div class="relative mb-6">
        <input
          type="password"
          name="password"
          id="password"
          class="w-full p-3 border border-gray-300 rounded-lg pr-10 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
          placeholder="Masukkan password Anda"
          required />
        <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-blue-600">
          <i id="eye-icon" class="fas fa-eye-slash"></i>
        </button>
      </div>

      <button
        type="submit"
        id="login-button"
        class="w-full bg-blue-600 text-white py-3 rounded-lg text-lg font-semibold hover:bg-blue-700 transition duration-200 shadow-md disabled:opacity-50 disabled:cursor-not-allowed">
        Login
      </button>

    </form>

  </div>
  <p class="text-xs text-center text-gray-500 mt-3">Slicing by - Indah Suci Ramadani</p>

</main>
<script>
  const togglePassword = document.getElementById('togglePassword');
  const password = document.getElementById('password');
  const eyeIcon = document.getElementById('eye-icon');

  togglePassword.addEventListener('click', function(e) {
    // Ubah tipe input antara 'password' dan 'text'
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);

    // Ganti ikon mata
    eyeIcon.classList.toggle('fa-eye');
    eyeIcon.classList.toggle('fa-eye-slash');
  });
</script>
<?php
include __DIR__ . "/script/processLogin.php";
include __DIR__ . "/../layout/footer.php"
?>