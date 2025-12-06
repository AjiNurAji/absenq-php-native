<?php include __DIR__ . "/../../layout/dashboard/top.php"; ?>

<!-- cancel add -->
<a href="/students" class="mb-4 text-white bg-red-600 px-4 py-1 w-fit block text-sm rounded-lg">Batal</a>
<div class="overflow-hidden bg-white p-4 rounded-lg shadow">
  <form id="student-form" class="text-left">
    <label for="id_number" class="block text-sm font-medium text-gray-700 mb-1">NIM</label>
    <input type="text" name="id_number" id="id_number"
      class="w-full p-3 border border-gray-300 rounded-lg mb-4 placeholder:text-gray-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
      placeholder="Masukkan NIM" required />

    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
    <input type="text" name="name" id="name"
      class="w-full p-3 border border-gray-300 rounded-lg mb-4 placeholder:text-gray-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
      placeholder="Masukkan nama lengkap" required />

    <label class="block text-sm font-medium text-gray-700 mb-1" for="class">Kelas</label>
    <select type="text" name="class_id" id="class"
      class="w-full p-3 border border-gray-300 rounded-lg mb-4 placeholder:text-gray-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
      required>
      <option value="null" selected disabled>Pilih kelas</option>
      <?php foreach ($classes as $class): ?>
        <option value="<?= $class->id ?>"><?= $class->class_name ?></option>
      <?php endforeach; ?>
    </select>

    <label class="block text-sm font-medium text-gray-700 mb-1" for="password">Kata Sandi</label>
    <div class="relative mb-6">
      <input type="text" name="password" id="password"
        class="w-full p-3 border border-gray-300 rounded-lg pr-10 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
        placeholder="Masukkan kata sandi baru" required />
    </div>

    <div class="flex justify-end items-center">
      <button type="submit" id="add-button"
        class="w-fit bg-blue-600 text-white px-3 rounded-lg text-md py-2 font-semibold hover:bg-blue-700 transition duration-200 shadow-md disabled:opacity-50 disabled:cursor-not-allowed">
        Tambah
      </button>
    </div>
  </form>
</div>

<?php include __DIR__ . "/../../layout/footerByAji.php" ?>
<?php include __DIR__ . "/../../layout/dashboard/bottom.php"; ?>
<script>
  const addForm = document.getElementById("student-form");
  const button = document.getElementById("add-button");

  addForm.addEventListener("submit", async (e) => {
    e.preventDefault();

    button.disabled = true;
    button.innerText = "Memproses...";

    // get value
    const formData = new FormData(addForm);
    const data = Object.fromEntries(formData);

    const res = await fetch("/student/create", {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify(data)
    });

    const result = await res.json();

    if (res.ok) {
      button.disabled = false;
      button.innerText = "Tambah";

      addForm.reset();

      Toastify({
        text: result.message,
        duration: 3000,
        backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
      }).showToast();
    } else {
      button.disabled = false;
      button.innerText = "Tambah";

      Toastify({
        text: result.message,
        duration: 3000,
        backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
      }).showToast();
    }
  })
</script>