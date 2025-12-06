<?php include __DIR__ . "/../layout/dashboard/top.php"; ?>

<div class="flex justify-end items-center">
  <a href="/schedule/create" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
    Tambah Jadwal
  </a>
</div>

<div class="grid mt-3 <?= empty($schedules) ? 'grid-cols-1' : 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4' ?>">
  <?php if (empty($schedules)): ?>
    <div class="bg-white shadow rounded-lg p-4">
      <p class="text-center">Belum ada jadwal.</p>
    </div>
    <?php
  else:
    foreach ($schedules as $i => $schedule): ?>
      <div class="bg-white shadow rounded-lg p-4 flex flex-col justify-between">
        <!-- Header -->
        <div class="flex justify-between items-center">
          <h2 class="font-medium text-gray-800"><?= $schedule->course_name ?></h2>
          <div class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">
            <?= $schedule->class_name ?>
          </div>
        </div>
        <!-- content -->
        <div class="my-3">
          <p class="text-gray-600">Tanggal: <?= $schedule->date ?></p>
          <p class="text-gray-600">Jam: <?= $schedule->start_time . " s/d " . $schedule->end_time ?></p>
          <p class="text-gray-600">Jumlah Hadir: <?= $schedule->present . "/" . $schedule->count_of_student ?></p>
        </div>
        <!-- footer -->
        <div class="flex items-center justify-center gap-3">
          <a href="/schedule/<?= $schedule->id ?>"
            class="bg-blue-500 inline-block w-full text-center hover:bg-blue-700 text-white text-sm py-2 px-4 rounded">
            Edit
          </a>
          <button class="bg-red-500 inline-block w-full text-center hover:bg-red-700 text-white text-sm py-2 px-4 rounded"
            onclick="deleteSchedule(<?= $schedule->id ?>)">Hapus</button>
          <a href="/schedule/<?= $schedule->id ?>/scan"
            class="bg-green-500 inline-block w-full text-center hover:bg-green-700 text-white text-sm py-2 px-4 rounded">Scan</a>
        </div>
      </div>
    <?php endforeach;
  endif; ?>
</div>
<?php include __DIR__ . "/../layout/footerByAji.php" ?>
<?php include __DIR__ . "/../layout/dashboard/bottom.php"; ?>
<script>
async function deleteSchedule(shedule_id) {
const con = confirm("Yakin menghapus jadwal ini?")

if (!con) return;

Toastify({
text: "Mohon tunggu...",
duration: 3000,
backgroundColor: "linear-gradient(to right, #004cb0ff, #3d69c9ff)",
}).showToast();

// execute
const response = await fetch("/schedule/delete", {
method: "POST",
headers: {
"Content-Type": "application/json"
},
body: JSON.stringify({ id: shedule_id })
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