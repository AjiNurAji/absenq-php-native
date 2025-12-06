<?php include __DIR__ . "/../../layout/dashboard/top.php"; ?>

<!-- cancel add -->
<a href="/dashboard" class="mb-4 text-white bg-red-600 px-4 py-1 w-fit block text-sm rounded-lg">Batal</a>
<div class="overflow-hidden bg-white p-4 rounded-lg shadow">
  <form id="student-form" class="text-left">
    <input type="text" class="sr-only" name="schedule_id" id="schedule_id" value="<?= $schedule_id ?>">
    <label class="block text-sm font-medium text-gray-700 mb-1" for="password">Alasan izin</label>
    <textarea name="note" id="note"
      class="w-full p-3 border border-gray-300 rounded-lg pr-10 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
      rows="4"></textarea>

    <div class="flex justify-end items-center">
      <button type="submit" id="add-button"
        class="w-fit bg-blue-600 text-white px-3 rounded-lg text-md py-2 font-semibold hover:bg-blue-700 transition duration-200 shadow-md disabled:opacity-50 disabled:cursor-not-allowed">
        Ajukan Izin
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

    const res = await fetch("/student/schedule/absent", {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify(data)
    });

    const result = await res.json();

    if (res.ok) {
      button.disabled = false;
      button.innerText = "Ajukan Izin";

      addForm.reset();

      Toastify({
        text: result.message,
        duration: 3000,
        backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
      }).showToast();

      window.location.href = "/dashboard";
      localStorage.clear();
    } else {
      button.disabled = false;
      button.innerText = "Ajukan Izin";

      Toastify({
        text: result.message,
        duration: 3000,
        backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
      }).showToast();
    }
  })
</script>