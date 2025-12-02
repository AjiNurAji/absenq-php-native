<?php include __DIR__ . "/../../layout/dashboard/top.php"; ?>

<div class="container mx-auto">
  <!-- cancel add -->
  <a href="/schedules" class="mb-4 text-white bg-red-600 px-4 py-1 w-fit block text-sm rounded-lg">Batal</a>
  <div class="overflow-hidden bg-white p-4 rounded-lg shadow">
    <form id="schedule-form" class="text-left">
      <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
      <input type="date" name="date" id="date" value="<?= htmlspecialchars($schedule->date) ?>"
        class="w-full p-3 border border-gray-300 rounded-lg mb-4 placeholder:text-gray-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
        required />

      <label for="course_id" class="block text-sm font-medium text-gray-700 mb-1">Mata Kuliah</label>
      <select name="course_id" id="course_id" value="<?= htmlspecialchars($schedule->course_id) ?>"
        class="w-full p-3 border border-gray-300 rounded-lg mb-4 placeholder:text-gray-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
        <option selected disabled>Pilih Mata Kuliah</option>
        <?php foreach ($courses as $i => $value): ?>
          <option <?= $schedule->course_id === $value->id ? "selected" : "" ?> value="<?= htmlspecialchars($value->id) ?>"
            key="<?= $i ?>"><?= htmlspecialchars($value->course_name) ?>
          </option>
        <?php endforeach; ?>
      </select>

      <label for="class_id" class="block text-sm font-medium text-gray-700 mb-1">Mata Kuliah</label>
      <select name="class_id" id="class_id" value="<?= htmlspecialchars($schedule->class_id) ?>"
        class="w-full p-3 border border-gray-300 rounded-lg mb-4 placeholder:text-gray-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
        <option selected disabled>Pilih Kelas</option>
        <?php foreach ($classes as $i => $value): ?>
          <option <?= $schedule->class_id === $value->id ? "selected" : "" ?> value="<?= htmlspecialchars($value->id) ?>"
            key="<?= $i ?>"><?= htmlspecialchars($value->class_name) ?>
          </option>
        <?php endforeach; ?>
      </select>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <div class="">
          <label for="start_time" class="block text-sm font-medium text-gray-700 mb-1">Mulai</label>
          <input type="time" name="start_time" id="start_time" value="<?= htmlspecialchars($schedule->start_time) ?>"
            class="w-full p-3 border border-gray-300 rounded-lg mb-4 placeholder:text-gray-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
            required />
        </div>
        <div class="">
          <label for="end_time" class="block text-sm font-medium text-gray-700 mb-1">Sampai</label>
          <input type="time" name="end_time" id="end_time" value="<?= htmlspecialchars($schedule->end_time) ?>"
            class="w-full p-3 border border-gray-300 rounded-lg mb-4 placeholder:text-gray-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
            required />
        </div>
      </div>

      <div class="flex justify-end items-center">
        <button type="submit" id="add-button"
          class="w-fit bg-blue-600 text-white px-3 rounded-lg text-md py-2 font-semibold hover:bg-blue-700 transition duration-200 shadow-md disabled:opacity-50 disabled:cursor-not-allowed">
          Ubah
        </button>
      </div>
    </form>
  </div>
</div>

<?php include __DIR__ . "/../../layout/footerByAji.php" ?>
<?php include __DIR__ . "/../../layout/dashboard/bottom.php"; ?>
<script>
  const addForm = document.getElementById("schedule-form");
  const button = document.getElementById("add-button");

  addForm.addEventListener("submit", async (e) => {
    e.preventDefault();

    button.disabled = true;
    button.innerText = "Memproses...";

    // get value
    const formData = new FormData(addForm);
    const data = Object.fromEntries(formData);

    const res = await fetch("/schedule/update/<?= $schedule->id ?>", {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify(data)
    });

    const result = await res.json();

    if (res.ok) {
      button.disabled = false;
      button.innerText = "Ubah";

      Toastify({
        text: result.message,
        duration: 3000,
        backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
      }).showToast();
    } else {
      button.disabled = false;
      button.innerText = "Ubah";

      Toastify({
        text: result.message,
        duration: 3000,
        backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
      }).showToast();
    }
  })
</script>