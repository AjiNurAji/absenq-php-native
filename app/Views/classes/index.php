<link rel="stylesheet" href="https://cdn.datatables.net/2.3.5/css/dataTables.dataTables.min.css" />
<?php include __DIR__ . "/../layout/dashboard/top.php"; ?>

<div class="container mx-auto px-4">
  <div class="flex justify-end items-center mb-4">
    <!-- create button -->
    <a href="/class/create" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
      Tambah Kelas
    </a>
  </div>
  <div class="overflow-hidden bg-white p-4 rounded-lg shadow">
    <div class="overflow-x-auto relative w-full">
      <table class="w-full text-sm text-left rtl:text-right text-body" id="myTable">
        <thead class="text-sm text-body bg-neutral-secondary-medium border-b border-t border-default-medium">
          <tr>
            <th scope="col" class="px-6 py-3 font-medium">
              ID
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
          <?php foreach ($classes as $class): ?>
            <tr class="bg-neutral-primary-soft border-b border-default hover:bg-neutral-secondary-medium">
              <th class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                <?= htmlspecialchars($class->id) ?>
              </th>
              <th class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                <?= htmlspecialchars($class->class_name) ?>
              </th>
              <td class="px-6 py-4 font-medium text-heading whitespace-nowrap flex items-center gap-3">
                <a href="/class/<?= $class->id ?>"
                  class="font-medium text-blue-500 hover:underline inline-block">Edit</a>
                <button type="button" id="button-delete" onclick="deleteClass(<?= $class->id ?>)"
                  class="font-medium text-red-600 hover:underline w-fit inline-block disabled:opacity-60 bg-transparent border-none outline-none">Hapus</button>
              </td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include __DIR__."/../layout/footerByAji.php" ?>
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
  async function deleteClass(class_id) {
    confirm("Yakin menghapus kelas ini?")

    Toastify({
      text: "Mohon tunggu...",
      duration: 3000,
      backgroundColor: "linear-gradient(to right, #004cb0ff, #3d69c9ff)",
    }).showToast();

    // execute
    const response = await fetch("/class/delete", {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify({ id: class_id })
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