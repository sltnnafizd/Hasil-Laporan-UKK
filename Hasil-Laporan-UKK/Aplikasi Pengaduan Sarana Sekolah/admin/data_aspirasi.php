<?php
session_start();
if(!isset($_SESSION['admin'])){ header("Location: ../login.php"); exit; }
include "../config/koneksi.php";

// ── Filter params ──────────────────────────────────────────
$filterStatus   = isset($_GET['status'])     ? mysqli_real_escape_string($conn, $_GET['status'])     : '';
$filterNis      = isset($_GET['nis'])        ? mysqli_real_escape_string($conn, trim($_GET['nis']))   : '';
$filterKategori = isset($_GET['kategori'])   ? (int)$_GET['kategori']                                : 0;
$filterTanggal  = isset($_GET['tanggal'])    ? mysqli_real_escape_string($conn, $_GET['tanggal'])     : '';
$filterBulan    = isset($_GET['bulan'])      ? mysqli_real_escape_string($conn, $_GET['bulan'])       : '';

// ── Build WHERE ────────────────────────────────────────────
$conditions = [];
if($filterStatus)   $conditions[] = "COALESCE(a.status,'Menunggu') = '$filterStatus'";
if($filterNis)      $conditions[] = "ia.nis LIKE '%$filterNis%'";
if($filterKategori) $conditions[] = "ia.id_kategori = $filterKategori";
if($filterTanggal)  $conditions[] = "DATE(ia.created_at) = '$filterTanggal'";
if($filterBulan)    $conditions[] = "DATE_FORMAT(ia.created_at,'%Y-%m') = '$filterBulan'";
$where = $conditions ? 'WHERE ' . implode(' AND ', $conditions) : '';

$data = mysqli_query($conn,"
    SELECT ia.*, k.ket_kategori,
           COALESCE(a.status,'Menunggu') as status,
           a.feedback, ia.created_at
    FROM input_aspirasi ia
    LEFT JOIN kategori k ON ia.id_kategori = k.id_kategori
    LEFT JOIN aspirasi a ON ia.id_pelaporan = a.id_pelaporan
    $where
    ORDER BY ia.id_pelaporan DESC
");

$totalSemua    = mysqli_num_rows(mysqli_query($conn,"SELECT id_pelaporan FROM input_aspirasi"));
$totalMenunggu = mysqli_fetch_row(mysqli_query($conn,"SELECT COUNT(*) FROM input_aspirasi ia LEFT JOIN aspirasi a ON ia.id_pelaporan=a.id_pelaporan WHERE COALESCE(a.status,'Menunggu')='Menunggu'"))[0];
$totalProses   = mysqli_fetch_row(mysqli_query($conn,"SELECT COUNT(*) FROM aspirasi WHERE status='Proses'"))[0];
$totalSelesai  = mysqli_fetch_row(mysqli_query($conn,"SELECT COUNT(*) FROM aspirasi WHERE status='Selesai'"))[0];

$kategoris = mysqli_query($conn,"SELECT * FROM kategori ORDER BY ket_kategori ASC");
$hasFilter = $filterStatus || $filterNis || $filterKategori || $filterTanggal || $filterBulan;
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Aspirasi — Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Inter', sans-serif; background: #f0fdf9; }
    .stat-card { transition: all 0.2s; cursor: pointer; }
    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
    .input-filter {
      border: 2px solid #e5e7eb; border-radius: 10px; padding: 8px 12px;
      font-size: 13px; outline: none; transition: all 0.2s; background: #f9fafb;
    }
    .input-filter:focus { border-color: #14b8a6; background: #fff; box-shadow: 0 0 0 3px rgba(20,184,166,0.1); }
  </style>
</head>
<body class="flex min-h-screen">

  <?php include '../layout/sidebar.php'; ?>

  <main class="flex-1 overflow-auto">

    <!-- Topbar -->
    <div class="bg-white border-b border-gray-200 px-8 py-4 flex items-center justify-between sticky top-0 z-10">
      <div>
        <h1 class="text-xl font-bold text-gray-800">Data Aspirasi</h1>
        <p class="text-gray-500 text-sm">Kelola semua pengaduan masuk</p>
      </div>
      <?php if($hasFilter): ?>
      <a href="data_aspirasi.php"
         class="flex items-center gap-2 text-sm text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 px-4 py-2 rounded-xl transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
        Reset Filter
      </a>
      <?php endif; ?>
    </div>

    <div class="p-8">

      <!-- Alert -->
      <?php if(isset($_GET['pesan'])): ?>
      <div class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-2xl text-sm">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        Operasi berhasil dilakukan.
      </div>
      <?php endif; ?>

      <!-- Stat Cards -->
      <div class="grid grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
        <a href="data_aspirasi.php" class="stat-card bg-white rounded-2xl p-5 border-2 <?= !$filterStatus && !$hasFilter ? 'border-teal-500' : 'border-transparent' ?> shadow-sm flex items-center gap-4">
          <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 bg-teal-50">
            <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
            </svg>
          </div>
          <div><p class="text-2xl font-bold text-gray-800"><?= $totalSemua ?></p><p class="text-xs text-gray-500 font-medium">Semua</p></div>
        </a>
        <a href="?status=Menunggu" class="stat-card bg-white rounded-2xl p-5 border-2 <?= $filterStatus==='Menunggu' ? 'border-yellow-400' : 'border-transparent' ?> shadow-sm flex items-center gap-4">
          <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 bg-yellow-50">
            <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
          <div><p class="text-2xl font-bold text-gray-800"><?= $totalMenunggu ?></p><p class="text-xs text-gray-500 font-medium">Menunggu</p></div>
        </a>
        <a href="?status=Proses" class="stat-card bg-white rounded-2xl p-5 border-2 <?= $filterStatus==='Proses' ? 'border-orange-400' : 'border-transparent' ?> shadow-sm flex items-center gap-4">
          <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 bg-orange-50">
            <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
          </div>
          <div><p class="text-2xl font-bold text-gray-800"><?= $totalProses ?></p><p class="text-xs text-gray-500 font-medium">Diproses</p></div>
        </a>
        <a href="?status=Selesai" class="stat-card bg-white rounded-2xl p-5 border-2 <?= $filterStatus==='Selesai' ? 'border-green-400' : 'border-transparent' ?> shadow-sm flex items-center gap-4">
          <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 bg-green-50">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
          <div><p class="text-2xl font-bold text-gray-800"><?= $totalSelesai ?></p><p class="text-xs text-gray-500 font-medium">Selesai</p></div>
        </a>
      </div>

      <!-- Filter Panel -->
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-6">
        <div class="flex items-center gap-2 mb-4">
          <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
          </svg>
          <h3 class="font-semibold text-gray-800 text-sm">Filter Data</h3>
          <?php if($hasFilter): ?>
          <span class="bg-teal-100 text-teal-700 text-xs font-semibold px-2 py-0.5 rounded-full">Aktif</span>
          <?php endif; ?>
        </div>
        <form method="GET" class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-3">
          <!-- NIS -->
          <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1">NIS Siswa</label>
            <input type="text" name="nis" value="<?= htmlspecialchars($filterNis) ?>"
                   placeholder="Cari NIS..." class="input-filter w-full">
          </div>
          <!-- Kategori -->
          <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1">Kategori</label>
            <select name="kategori" class="input-filter w-full">
              <option value="">Semua Kategori</option>
              <?php
              mysqli_data_seek($kategoris, 0);
              while($k = mysqli_fetch_assoc($kategoris)):
              ?>
              <option value="<?= $k['id_kategori'] ?>" <?= $filterKategori == $k['id_kategori'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($k['ket_kategori']) ?>
              </option>
              <?php endwhile; ?>
            </select>
          </div>
          <!-- Status -->
          <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1">Status</label>
            <select name="status" class="input-filter w-full">
              <option value="">Semua Status</option>
              <option value="Menunggu" <?= $filterStatus==='Menunggu' ? 'selected' : '' ?>>Menunggu</option>
              <option value="Proses"   <?= $filterStatus==='Proses'   ? 'selected' : '' ?>>Proses</option>
              <option value="Selesai"  <?= $filterStatus==='Selesai'  ? 'selected' : '' ?>>Selesai</option>
            </select>
          </div>
          <!-- Per Tanggal -->
          <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1">Per Tanggal</label>
            <input type="date" name="tanggal" value="<?= htmlspecialchars($filterTanggal) ?>"
                   class="input-filter w-full">
          </div>
          <!-- Per Bulan -->
          <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1">Per Bulan</label>
            <input type="month" name="bulan" value="<?= htmlspecialchars($filterBulan) ?>"
                   class="input-filter w-full">
          </div>
          <!-- Tombol -->
          <div class="col-span-2 md:col-span-3 xl:col-span-5 flex gap-2 pt-1">
            <button type="submit"
                    class="flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold px-5 py-2 rounded-xl transition">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
              </svg>
              Terapkan Filter
            </button>
            <a href="data_aspirasi.php"
               class="flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-medium px-5 py-2 rounded-xl transition">
              Reset
            </a>
          </div>
        </form>
      </div>

      <!-- Table -->
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
          <div class="flex items-center gap-2">
            <h2 class="font-bold text-gray-800">Daftar Pengaduan</h2>
            <?php if($hasFilter): ?>
            <span class="text-xs px-3 py-1 rounded-full font-semibold bg-teal-100 text-teal-700">
              <?= mysqli_num_rows($data) ?> hasil
            </span>
            <?php endif; ?>
          </div>
          <div class="relative">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
              </svg>
            </span>
            <input type="text" id="searchInput" placeholder="Cari cepat..."
                   class="pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-300 w-48">
          </div>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full text-sm">
            <thead>
              <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wide">
                <th class="px-5 py-3 text-left w-8">No</th>
                <th class="px-5 py-3 text-left">NIS</th>
                <th class="px-5 py-3 text-left">Kategori</th>
                <th class="px-5 py-3 text-left">Lokasi</th>
                <th class="px-5 py-3 text-left">Keterangan</th>
                <th class="px-5 py-3 text-left">Tanggal</th>
                <th class="px-5 py-3 text-left">Status</th>
                <th class="px-5 py-3 text-left">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-50" id="tableBody">
              <?php $no=1; while($d = mysqli_fetch_assoc($data)):
                $status = $d['status'];
                $badge = match($status) {
                  'Selesai' => 'bg-green-100 text-green-700',
                  'Proses'  => 'bg-orange-100 text-orange-700',
                  default   => 'bg-yellow-100 text-yellow-700',
                };
                $dot = match($status) {
                  'Selesai' => 'bg-green-500',
                  'Proses'  => 'bg-orange-500',
                  default   => 'bg-yellow-500 animate-pulse',
                };
              ?>
              <tr class="hover:bg-teal-50 transition-colors">
                <td class="px-5 py-4 text-gray-400 text-xs"><?= $no++ ?></td>
                <td class="px-5 py-4 font-semibold text-gray-800"><?= htmlspecialchars($d['nis']) ?></td>
                <td class="px-5 py-4">
                  <span class="inline-flex items-center gap-1 bg-teal-50 text-teal-700 text-xs font-medium px-2 py-1 rounded-lg">
                    <?= htmlspecialchars($d['ket_kategori'] ?? '-') ?>
                  </span>
                </td>
                <td class="px-5 py-4 text-gray-600 max-w-[140px] truncate" title="<?= htmlspecialchars($d['lokasi']) ?>">
                  <?= htmlspecialchars($d['lokasi']) ?>
                </td>
                <td class="px-5 py-4 text-gray-500 max-w-[180px]">
                  <span class="truncate block" title="<?= htmlspecialchars($d['ket']) ?>">
                    <?= htmlspecialchars(mb_strimwidth($d['ket'], 0, 50, '...')) ?>
                  </span>
                </td>
                <td class="px-5 py-4 text-gray-500 text-xs whitespace-nowrap">
                  <?= date('d M Y', strtotime($d['created_at'])) ?>
                </td>
                <td class="px-5 py-4">
                  <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold <?= $badge ?>">
                    <span class="w-1.5 h-1.5 rounded-full <?= $dot ?>"></span>
                    <?= $status ?>
                  </span>
                </td>
                <td class="px-5 py-4">
                  <div class="flex items-center gap-2">
                    <a href="feedback.php?id=<?= $d['id_pelaporan'] ?>"
                       class="inline-flex items-center gap-1 bg-teal-600 hover:bg-teal-700 text-white text-xs font-medium px-3 py-1.5 rounded-lg transition">
                      <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                      </svg>
                      Proses
                    </a>
                    <a href="../proses/hapus.php?id=<?= $d['id_pelaporan'] ?>"
                       onclick="return confirm('Yakin hapus pengaduan ini?')"
                       class="inline-flex items-center gap-1 bg-red-50 hover:bg-red-100 text-red-600 text-xs font-medium px-3 py-1.5 rounded-lg transition">
                      <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                      </svg>
                      Hapus
                    </a>
                  </div>
                </td>
              </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>

        <?php mysqli_data_seek($data, 0); if(mysqli_num_rows($data) === 0): ?>
        <div class="py-16 text-center">
          <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
          </div>
          <p class="text-gray-500 font-medium">Tidak ada data ditemukan</p>
          <p class="text-gray-400 text-sm mt-1">Coba ubah atau reset filter</p>
        </div>
        <?php endif; ?>

        <div class="px-6 py-3 border-t border-gray-100 bg-gray-50 text-xs text-gray-500">
          Menampilkan <?= mysqli_num_rows($data) ?> dari <?= $totalSemua ?> pengaduan
        </div>
      </div>
    </div>
  </main>

  <script>
    document.getElementById('searchInput').addEventListener('input', function() {
      const q = this.value.toLowerCase();
      document.querySelectorAll('#tableBody tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
      });
    });
  </script>
</body>
</html>
