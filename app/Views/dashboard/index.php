<?php include __DIR__ . "/../layout/dashboard/top.php" ?>
<?php
$avg_this = $avgPerMonth->avg_this_month ?? 0;
$avg_last = $avgPerMonth->avg_last_month ?? 0;

if (!$avg_this && !$avg_last) {
  $growth = 0;
} elseif ($avg_last > 0) {
  $growth = (($avg_this - $avg_last) / $avg_last) * 100;
} else {
  $growth = 100;
}

?>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">

  <div class="card relative">
    <div class="flex justify-between items-start mb-2">
      <span class="text-gray-500 text-sm font-medium">Total Mahasiswa</span>
      <i class="fa-regular fa-user text-gray-400"></i>
    </div>
    <div class="text-3xl font-bold text-gray-800 mb-1"><?= htmlspecialchars($presentToDay->total_students) ?></div>
    <div class="text-xs text-gray-500">Terdaftar aktif</div>
  </div>

  <div class="card relative">
    <div class="flex justify-between items-start mb-2">
      <span class="text-gray-500 text-sm font-medium">Hadir hari ini</span>
      <i class="fa-solid fa-user-check text-gray-400"></i>
    </div>
    <div class="text-3xl font-bold text-green-500 mb-1"><?= htmlspecialchars($presentToDay->present_count) ?></div>
    <div class="text-xs text-gray-500"><?= htmlspecialchars(number_format($presentToDay->percentage, 1)) ?>% kehadiran
    </div>
  </div>

  <div class="card relative">
    <div class="flex justify-between items-start mb-2">
      <span class="text-gray-500 text-sm font-medium">Tidak absen</span>
      <i class="fa-regular fa-clock text-gray-400"></i>
    </div>
    <div class="text-3xl font-bold text-red-500 mb-1"><?= htmlspecialchars($notScan) ?></div>
    <div class="text-xs text-gray-500">Perlu tindak lanjut</div>
  </div>

  <div class="card relative">
    <div class="flex justify-between items-start mb-2">
      <span class="text-gray-500 text-sm font-medium">Rata-rata Bulan Ini</span>
      <i class="fa-regular fa-calendar text-gray-400"></i>
    </div>
    <div class="text-3xl font-bold text-blue-500 mb-1"><?= number_format($avg_this, 1) ?>%</div>
    <div class="text-xs text-gray-500">+<?= number_format($growth, 1) ?>% dari bulan lalu</div>
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

<?php include __DIR__ . "/../layout/footerByNessya.php" ?>
<?php include __DIR__ . "/../layout/dashboard/bottom.php" ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  // Konfigurasi umum font chart agar mirip
  Chart.defaults.font.family = "'Inter', sans-serif";
  Chart.defaults.color = '#9ca3af';

  async function weeklyChart()
  {
    // 1. BAR CHART (Kehadiran Minggu Ini)
    await fetch("/attendance/chart/weekly", {
      method: "GET"
    })
      .then(res => res.json())
      .then(res => {
        const ctxBar = document.getElementById('barChart').getContext('2d');
        new Chart(ctxBar, {
          type: 'bar',
          data: {
            labels: res.present.labels,
            datasets: [{
              label: 'Hadir',
              data: res.present.values, // Data dummy visual
              backgroundColor: '#22c55e', // Hijau Tailwind
              borderRadius: 2,
              barPercentage: 0.6,
              categoryPercentage: 0.8
            },
            {
              label: 'Tidak Hadir',
              data: res.absent.values, // Data dummy visual
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
      })
  }

  async function monthlyChart()
  {
    // 2. LINE CHART (Tren Absensi 6 Bulan)
    await fetch("/attendance/chart/monthly", {
      method: "GET"
    })
    .then(res => res.json())
    .then(res => {
      const ctxLine = document.getElementById('lineChart').getContext('2d');
    
      // Membuat gradient untuk efek halus di bawah garis (opsional, biar makin bagus)
      let gradient = ctxLine.createLinearGradient(0, 0, 0, 300);
      gradient.addColorStop(0, 'rgba(59, 130, 246, 0.1)'); // Biru transparan
      gradient.addColorStop(1, 'rgba(59, 130, 246, 0)');
    
      new Chart(ctxLine, {
        type: 'line',
        data: {
          labels: res.labels,
          datasets: [{
            label: 'Total Hadir',
            data: res.values, // Estimasi data dari gambar
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
    });
  }

  weeklyChart();
  monthlyChart();
</script>