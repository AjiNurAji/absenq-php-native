<?php include __DIR__ . "/../layout/dashboard/top.php" ?>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">

  <div class="card relative">
    <div class="flex justify-between items-start mb-2">
      <span class="text-gray-500 text-sm font-medium">Total Mahasiswa</span>
      <i class="fa-regular fa-user text-gray-400"></i>
    </div>
    <div class="text-3xl font-bold text-gray-800 mb-1">150</div>
    <div class="text-xs text-gray-500">Terdaftar aktif</div>
  </div>

  <div class="card relative">
    <div class="flex justify-between items-start mb-2">
      <span class="text-gray-500 text-sm font-medium">Hadir Hari Ini</span>
      <i class="fa-solid fa-user-check text-gray-400"></i>
    </div>
    <div class="text-3xl font-bold text-green-500 mb-1">142</div>
    <div class="text-xs text-gray-500">94.7% kehadiran</div>
  </div>

  <div class="card relative">
    <div class="flex justify-between items-start mb-2">
      <span class="text-gray-500 text-sm font-medium">Belum Check-In</span>
      <i class="fa-regular fa-clock text-gray-400"></i>
    </div>
    <div class="text-3xl font-bold text-red-500 mb-1">8</div>
    <div class="text-xs text-gray-500">Perlu tindak lanjut</div>
  </div>

  <div class="card relative">
    <div class="flex justify-between items-start mb-2">
      <span class="text-gray-500 text-sm font-medium">Rata-rata Bulan Ini</span>
      <i class="fa-regular fa-calendar text-gray-400"></i>
    </div>
    <div class="text-3xl font-bold text-blue-500 mb-1">93.2%</div>
    <div class="text-xs text-gray-500">+2.3% dari bulan lalu</div>
  </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">

  <div class="card">
    <div class="mb-6">
      <h2 class="text-lg font-bold text-gray-800">Kehadiran Minggu Ini</h2>
      <p class="text-xs text-gray-500">Perbandingan hadir vs tidak hadir</p>
    </div>
    <div class="h-64">
      <canvas id="barChart"></canvas>
    </div>
  </div>

  <div class="card">
    <div class="mb-6">
      <h2 class="text-lg font-bold text-gray-800">Tren Absensi 6 Bulan</h2>
      <p class="text-xs text-gray-500">Total kehadiran per bulan</p>
    </div>
    <div class="h-64">
      <canvas id="lineChart"></canvas>
    </div>
  </div>
</div>

<footer class="flex md:flex-row flex-col w-full justify-center md:justify-between px-4 align-center py-6 text-center bg-gray-50">
  <p class="text-xs text-gray-500">Slicing by - Nessya Cipto Meilody</p>
  <p class="text-xs text-gray-500">© 2025 AbsenQ. All rights reserved.</p>
</footer>
<?php include __DIR__ . "/../layout/dashboard/bottom.php" ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  // Konfigurasi umum font chart agar mirip
  Chart.defaults.font.family = "'Inter', sans-serif";
  Chart.defaults.color = '#9ca3af';

  // 1. BAR CHART (Kehadiran Minggu Ini)
  const ctxBar = document.getElementById('barChart').getContext('2d');
  new Chart(ctxBar, {
    type: 'bar',
    data: {
      labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum'],
      datasets: [{
          label: 'Hadir',
          data: [45, 48, 46, 47, 44], // Data dummy visual
          backgroundColor: '#22c55e', // Hijau Tailwind
          borderRadius: 2,
          barPercentage: 0.6,
          categoryPercentage: 0.8
        },
        {
          label: 'Tidak Hadir',
          data: [5, 2, 4, 3, 6], // Data dummy visual
          backgroundColor: '#ef4444', // Merah Tailwind
          borderRadius: 2,
          barPercentage: 0.6,
          categoryPercentage: 0.8
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'bottom',
          labels: {
            usePointStyle: true,
            pointStyle: 'rectRounded',
            padding: 20,
            color: '#6b7280'
          }
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          max: 60,
          grid: {
            borderDash: [5, 5],
            color: '#e5e7eb',
            drawBorder: false
          },
          ticks: {
            stepSize: 15
          }
        },
        x: {
          grid: {
            display: false,
            drawBorder: false
          }
        }
      }
    }
  });

  // 2. LINE CHART (Tren Absensi 6 Bulan)
  const ctxLine = document.getElementById('lineChart').getContext('2d');

  // Membuat gradient untuk efek halus di bawah garis (opsional, biar makin bagus)
  let gradient = ctxLine.createLinearGradient(0, 0, 0, 300);
  gradient.addColorStop(0, 'rgba(59, 130, 246, 0.1)'); // Biru transparan
  gradient.addColorStop(1, 'rgba(59, 130, 246, 0)');

  new Chart(ctxLine, {
    type: 'line',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
      datasets: [{
        label: 'Total Hadir',
        data: [920, 1050, 1100, 980, 1180, 1220], // Estimasi data dari gambar
        borderColor: '#3b82f6', // Biru Tailwind
        backgroundColor: gradient,
        borderWidth: 2,
        tension: 0.4, // Membuat garis melengkung (curved)
        pointRadius: 0, // Hilangkan titik pada garis agar bersih
        pointHoverRadius: 5,
        fill: true
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'bottom',
          labels: {
            usePointStyle: true,
            pointStyle: 'circle', // Simbol garis-tengah di legend
            padding: 20,
            color: '#6b7280'
          }
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          max: 1250,
          grid: {
            borderDash: [5, 5],
            color: '#e5e7eb',
            drawBorder: false
          },
          ticks: {
            stepSize: 300
          }
        },
        x: {
          grid: {
            display: false,
            drawBorder: false
          }
        }
      }
    }
  });
</script>