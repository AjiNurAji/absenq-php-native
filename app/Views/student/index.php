<link rel="stylesheet" href="https://cdn.datatables.net/2.3.5/css/dataTables.dataTables.min.css" />
<?php include __DIR__ . "/../layout/dashboard/top.php"; ?>

<div class="container mx-auto">
  <div class="flex justify-between items-center mb-4">
    <!-- filter by class -->
    <select id="filter-class" class="px-4 py-2 rounded shadow border">
      <option <?= $filter == "0" ? "selected" : "" ?> value="0">Semua</option>
      <?php foreach ($classes as $class): ?>
        <option <?= $filter == $class->id ? "selected" : "" ?> value="<?= $class->id ?>"><?= $class->class_name ?></option>
      <?php endforeach; ?>
    </select>

    <!-- create button -->
    <a href="/student/create" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
      Tambah Mahasiswa
    </a>
  </div>
  <div class="overflow-hidden bg-white p-4 rounded-lg shadow">
    <div class="overflow-x-auto relative w-full">
      <table class="w-full text-sm text-left rtl:text-right text-body" id="myTable">
        <thead class="text-sm text-body bg-neutral-secondary-medium border-b border-t border-default-medium">
          <tr>
            <th scope="col" class="px-6 py-3 font-medium">
              NIM
            </th>
            <th scope="col" class="px-6 py-3 font-medium">
              Nama
            </th>
            <th scope="col" class="px-6 py-3 font-medium">
              Kelas
            </th>
            <th scope="col" class="px-6 py-3 font-medium">
              Aksi
            </th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($students as $student): ?>
            <tr class="bg-neutral-primary-soft border-b border-default hover:bg-neutral-secondary-medium">
              <td class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                <?= htmlspecialchars($student->student_id) ?>
              </td>
              <td class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                <?= htmlspecialchars($student->name) ?>
              </td>
              <td class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                <?= htmlspecialchars($student->class_name) ?>
              </td>
              <td class="px-6 py-4 font-medium text-heading whitespace-nowrap flex items-center gap-3">
                <a href="/student/<?= $student->student_id ?>"
                  class="font-medium text-blue-500 hover:underline inline-block">Edit</a>
                <button type="button" id="button-delete" onclick="deleteStudent(<?= $student->student_id ?>)"
                  class="font-medium text-red-600 hover:underline w-fit inline-block disabled:opacity-60 bg-transparent border-none outline-none">Hapus</button>
              </td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php include __DIR__ . "/../layout/footerByAji.php" ?>
<?php include __DIR__ . "/../layout/dashboard/bottom.php"; ?>
<!-- Include jQuery (DataTables is a jQuery plugin) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/2.3.5/js/dataTables.js"></script>
<script>

  $(document).ready(function () {
    $('#myTable').DataTable({
      responsive: true
    });
  });

</script>
<script>
  const filterClass = document.getElementById("filter-class");

  filterClass.addEventListener("change", (e) => {
    e.preventDefault();
    window.location.href = "/students?class=" + e.target.value
  });
</script>
<script>
  async function deleteStudent(student_id) {
    const con = confirm("Yakin menghapus mahasiswa ini?")

    if (!con) return;

    Toastify({
      text: "Mohon tunggu...",
      duration: 3000,
      backgroundColor: "linear-gradient(to right, #004cb0ff, #3d69c9ff)",
    }).showToast();

    // execute
    const response = await fetch("/student/delete", {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify({ student_id })
    });

    const result = await response.json();

    if (response.ok) {

      Toastify({
        text: result.message,
        duration: 3000,
        backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
      }).showToast();

      window.location.reload();
    } else {

      Toastify({
        text: result.message,
        duration: 3000,
        backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
      }).showToast();
    }
  }
</script>