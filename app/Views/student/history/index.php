<link rel="stylesheet" href="https://cdn.datatables.net/2.3.5/css/dataTables.dataTables.min.css" />
<?php include __DIR__ . "/../../layout/dashboard/top.php"; ?>

<div class="container mx-auto">
  <div class="overflow-hidden bg-white p-4 rounded-lg shadow">
    <div class="overflow-x-auto relative w-full">
      <table class="w-full text-sm text-left rtl:text-right text-body" id="myTable">
        <thead class="text-sm text-body bg-neutral-secondary-medium border-b border-t border-default-medium">
          <tr>
            <th scope="col" class="px-6 py-3 font-medium">
              No
            </th>
            <th scope="col" class="px-6 py-3 font-medium">
              Nama Lengkap
            </th>
            <th scope="col" class="px-6 py-3 font-medium">
              Kelas
            </th>
            <th scope="col" class="px-6 py-3 font-medium">
              Mata Kuliah
            </th>
            <th scope="col" class="px-6 py-3 font-medium">
              Masuk
            </th>
            <th scope="col" class="px-6 py-3 font-medium">
              Pulang
            </th>
            <th scope="col" class="px-6 py-3 font-medium">
              Status
            </th>
            <th scope="col" class="px-6 py-3 font-medium">
              Catatan
            </th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($attendances as $i => $value): ?>
            <tr class="bg-neutral-primary-soft border-b border-default hover:bg-neutral-secondary-medium">
              <td class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                <?= htmlspecialchars($i + 1) ?>
              </td>
              <td class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                <?= htmlspecialchars($value->student_name) ?>
              </td>
              <td class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                <?= htmlspecialchars($value->class_name) ?>
              </td>
              <td class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                <?= htmlspecialchars($value->course_name) ?>
              </td>
              <td class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                <?= htmlspecialchars(toIDTime($value->in_time)) ?>
              </td>
              <td class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                <?= htmlspecialchars( $value->out_time ?  toIDTime($value->out_time) : "") ?>
              </td>
              <td class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                <?= htmlspecialchars($value->status === "present" ? "Hadir" : "Tidak Hadir") ?>
              </td>
              <td class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                <?= htmlspecialchars($value->note) ?>
              </td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include __DIR__ . "/../../layout/footerByAji.php" ?>
<?php include __DIR__ . "/../../layout/dashboard/bottom.php"; ?>
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