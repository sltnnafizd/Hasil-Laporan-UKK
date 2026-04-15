<?php
session_start();
if(!isset($_SESSION['admin'])){ header("Location: ../login.php"); exit; }
include "../config/koneksi.php";

$totalSemua    = mysqli_num_rows(mysqli_query($conn,"SELECT id_pelaporan FROM input_aspirasi"));
$totalMenunggu = mysqli_fetch_row(mysqli_query($conn,"SELECT COUNT(*) FROM input_aspirasi ia LEFT JOIN aspirasi a ON ia.id_pelaporan=a.id_pelaporan WHERE COALESCE(a.status,'Menunggu')='Menunggu'"))[0];
$totalProses   = mysqli_fetch_row(mysqli_query($conn,"SELECT COUNT(*) FROM aspirasi WHERE status='Proses'"))[0];
$totalSelesai  = mysqli_fetch_row(mysqli_query($conn,"SELECT COUNT(*) FROM aspirasi WHERE status='Selesai'"))[0];

// 5 pengaduan terbaru
$terbaru = mysqli_query($conn,"
    SELECT ia.id_pelaporan, ia.nis, ia.lokasi, k.ket_kategori,
           COALESCE(a.status,'Menunggu') as status
    FROM input_aspirasi ia
    LEFT JOIN kategori k ON ia.id_kategori = k.id_kategori
    LEFT JOIN aspirasi a ON ia.id_pelaporan = a.id_pelaporan
    ORDER BY ia.id_pelaporan DESC LIMIT 5
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard — Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Inter', sans-serif; background: #f0fdf9; }
  </style>
</head>
<body class="flex min-h-screen">

  <?php include '../layout/sidebar.php'; ?>

  <!-- Main -->
  <main class="flex-1 overflow-auto">

    <!-- Topbar -->
    <div class="bg-white border-b border-gray-200 px-8 py-4 flex items-center justify-between sticky top-0 z-10">
      <div>
        <h1 class="text-xl font-bold text-gray-800">Dashboard</h1>
        <p class="text-gray-500 text-sm">Selamat datang kembali, <span class="font-semibold text-teal-600"><?= htmlspecialchars($_SESSION['admin']) ?></span></p>
      </div>
      <div class="flex items-center gap-2 text-sm text-gray-500">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        <?= date('d F Y') ?>
      </div>
    </div>

    <div class="p-8">

      <!-- Stat Cards -->
      <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">

        <!-- Total -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-4">
          <div class="w-14 h-14 rounded-2xl flex items-center justify-center flex-shrink-0"
               style="background: linear-gradient(135deg, #ccfbf1, #99f6e4);">
            <svg class="w-7 h-7 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
          </div>
          <div>
            <p class="text-3xl font-bold text-gray-800"><?= $totalSemua ?></p>
            <p class="text-sm text-gray-500 font-medium">Total Pengaduan</p>
          </div>
        </div>

        <!-- Menunggu -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-4">
          <div class="w-14 h-14 rounded-2xl flex items-center justify-center flex-shrink-0"
               style="background: linear-gradient(135deg, #fef9c3, #fef08a);">
            <svg class="w-7 h-7 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
          <div>
            <p class="text-3xl font-bold text-gray-800"><?= $totalMenunggu ?></p>
            <p class="text-sm text-gray-500 font-medium">Menunggu</p>
          </div>
        </div>

        <!-- Proses -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-4">
          <div class="w-14 h-14 rounded-2xl flex items-center justify-center flex-shrink-0"
               style="background: linear-gradient(135deg, #ffedd5, #fed7aa);">
            <svg class="w-7 h-7 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
          </div>
          <div>
            <p class="text-3xl font-bold text-gray-800"><?= $totalProses ?></p>
            <p class="text-sm text-gray-500 font-medium">Diproses</p>
          </div>
        </div>

        <!-- Selesai -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-4">
          <div class="w-14 h-14 rounded-2xl flex items-center justify-center flex-shrink-0"
               style="background: linear-gradient(135deg, #dcfce7, #bbf7d0);">
            <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
          <div>
            <p class="text-3xl font-bold text-gray-800"><?= $totalSelesai ?></p>
            <p class="text-sm text-gray-500 font-medium">Selesai</p>
          </div>
        </div>
      </div>

      <!-- Progress bar -->
      <?php if($totalSemua > 0): ?>
      <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-8">
        <h2 class="font-bold text-gray-800 mb-4">Progres Penanganan</h2>
        <div class="flex rounded-full overflow-hidden h-4 bg-gray-100">
          <?php
          $pct = fn($n) => $totalSemua > 0 ? round($n/$totalSemua*100) : 0;
          if($pct($totalMenunggu) > 0) echo "<div class='bg-yellow-400 h-4 transition-all' style='width:{$pct($totalMenunggu)}%' title='Menunggu'></div>";
          if($pct($totalProses) > 0)   echo "<div class='bg-orange-400 h-4 transition-all' style='width:{$pct($totalProses)}%' title='Proses'></div>";
          if($pct($totalSelesai) > 0)  echo "<div class='bg-green-400 h-4 transition-all' style='width:{$pct($totalSelesai)}%' title='Selesai'></div>";
          ?>
        </div>
        <div class="flex gap-6 mt-3 text-xs text-gray-500">
          <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-yellow-400 inline-block"></span> Menunggu <?= $pct($totalMenunggu) ?>%</span>
          <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-orange-400 inline-block"></span> Proses <?= $pct($totalProses) ?>%</span>
          <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-green-400 inline-block"></span> Selesai <?= $pct($totalSelesai) ?>%</span>
        </div>
      </div>
      <?php endif; ?>

      <!-- Tabel terbaru -->
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
          <h2 class="font-bold text-gray-800">Pengaduan Terbaru</h2>
          <a href="data_aspirasi.php" class="text-sm text-teal-600 hover:text-teal-700 font-medium">Lihat semua →</a>
        </div>
        <div class="overflow-x-auto">
          <table class="w-full text-sm">
            <thead>
              <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wide">
                <th class="px-6 py-3 text-left">NIS</th>
                <th class="px-6 py-3 text-left">Kategori</th>
                <th class="px-6 py-3 text-left">Lokasi</th>
                <th class="px-6 py-3 text-left">Status</th>
                <th class="px-6 py-3 text-left">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
              <?php while($row = mysqli_fetch_assoc($terbaru)):
                $badge = match($row['status']) {
                  'Selesai' => 'bg-green-100 text-green-700',
                  'Proses'  => 'bg-orange-100 text-orange-700',
                  default   => 'bg-yellow-100 text-yellow-700',
                };
              ?>
              <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 font-medium text-gray-800"><?= htmlspecialchars($row['nis']) ?></td>
                <td class="px-6 py-4 text-gray-600"><?= htmlspecialchars($row['ket_kategori'] ?? '-') ?></td>
                <td class="px-6 py-4 text-gray-600"><?= htmlspecialchars($row['lokasi']) ?></td>
                <td class="px-6 py-4">
                  <span class="px-3 py-1 rounded-full text-xs font-semibold <?= $badge ?>"><?= $row['status'] ?></span>
                </td>
                <td class="px-6 py-4">
                  <a href="feedback.php?id=<?= $row['id_pelaporan'] ?>"
                     class="text-teal-600 hover:text-teal-700 font-medium text-xs">Proses →</a>
                </td>
              </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </main>

</body>
</html>
