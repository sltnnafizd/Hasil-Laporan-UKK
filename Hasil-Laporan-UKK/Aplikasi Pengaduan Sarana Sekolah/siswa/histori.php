<?php include "../config/koneksi.php"; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Histori Pengaduan</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Inter', sans-serif; }
    .gradient-bg { background: linear-gradient(135deg, #042f2e 0%, #0f766e 60%, #14b8a6 100%); }
    .progress-bar { transition: width 1s ease-in-out; }
  </style>
</head>
<body class="min-h-screen" style="background: #f0fdf9;">

<?php include "../layout/navbar_siswa.php"; ?>

  <!-- Hero -->
  <div class="gradient-bg py-10 px-4">
    <div class="max-w-5xl mx-auto text-center">
      <div class="inline-flex items-center gap-2 bg-white bg-opacity-20 text-white text-sm px-4 py-2 rounded-full mb-3">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
        Riwayat Laporan
      </div>
      <h2 class="text-3xl font-bold text-white mb-2">Histori Pengaduan</h2>
      <p class="text-teal-100 text-sm">Pantau status dan progres perbaikan pengaduan kamu</p>
    </div>
  </div>

  <div class="max-w-6xl mx-auto px-4 -mt-6 pb-12">

    <!-- Form cari NIS -->
    <?php
    $nisInput = isset($_GET['nis']) ? trim($_GET['nis']) : '';
    ?>
    <div class="bg-white rounded-2xl shadow-lg p-5 mb-6">
      <form method="GET" class="flex gap-3 items-end flex-wrap">
        <div class="flex-1 min-w-48">
          <label class="block text-sm font-semibold text-gray-700 mb-1.5">Masukkan NIS kamu</label>
          <div class="relative">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
              </svg>
            </span>
            <input type="text" name="nis" value="<?= htmlspecialchars($nisInput) ?>"
                   placeholder="Contoh: 2324123456 "
                   class="pl-9 pr-4 py-2.5 w-full border-2 border-gray-200 rounded-xl text-sm focus:outline-none focus:border-teal-400 focus:ring-2 focus:ring-teal-100 transition">
          </div>
        </div>
        <button type="submit"
                class="flex items-center gap-2 text-white font-semibold px-5 py-2.5 rounded-xl transition"
                style="background:linear-gradient(135deg,#0f766e,#14b8a6);">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
          </svg>
          Cek Pengaduan
        </button>
        <?php if($nisInput): ?>
        <a href="histori.php" class="flex items-center gap-1 text-sm text-gray-400 hover:text-gray-600 px-3 py-2.5 rounded-xl border border-gray-200 hover:bg-gray-50 transition">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
          Reset
        </a>
        <?php endif; ?>
      </form>
    </div>

    <?php
    $nisEsc = mysqli_real_escape_string($conn, $nisInput);
    $query = "SELECT ia.id_pelaporan, ia.nis, ia.lokasi, ia.ket, ia.created_at,
                     k.ket_kategori,
                     COALESCE(a.status,'Menunggu') as status,
                     a.feedback, a.updated_at as tgl_update
              FROM input_aspirasi ia
              JOIN kategori k ON ia.id_kategori = k.id_kategori
              LEFT JOIN aspirasi a ON ia.id_pelaporan = a.id_pelaporan
              WHERE ia.nis = '$nisEsc'
              ORDER BY ia.id_pelaporan DESC";
    $result = mysqli_query($conn, $query);
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Filter bar
    ?>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-6 flex flex-wrap gap-3 items-center justify-between">
      <p class="text-sm text-gray-600">
        Menampilkan pengaduan untuk NIS <span class="font-bold text-teal-700"><?= htmlspecialchars($nisInput) ?></span>
        — <span class="font-semibold"><?= count($rows) ?></span> pengaduan ditemukan
      </p>
      <div class="flex gap-2 flex-wrap">
        <button onclick="filterStatus('')"        class="filter-btn text-xs font-semibold px-4 py-2 rounded-xl border-2 border-teal-500 bg-teal-50 text-teal-700 transition" data-status="">Semua</button>
        <button onclick="filterStatus('Menunggu')" class="filter-btn text-xs font-semibold px-4 py-2 rounded-xl border-2 border-gray-200 text-gray-500 transition" data-status="Menunggu">Menunggu</button>
        <button onclick="filterStatus('Proses')"   class="filter-btn text-xs font-semibold px-4 py-2 rounded-xl border-2 border-gray-200 text-gray-500 transition" data-status="Proses">Diproses</button>
        <button onclick="filterStatus('Selesai')"  class="filter-btn text-xs font-semibold px-4 py-2 rounded-xl border-2 border-gray-200 text-gray-500 transition" data-status="Selesai">Selesai</button>
      </div>
    </div>

    <?php if(count($rows) === 0): ?>
    <div class="bg-white rounded-2xl shadow-sm p-16 text-center">
      <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
      </div>
      <p class="text-gray-600 font-semibold">Belum ada pengaduan</p>
      <a href="../index.php" class="inline-block mt-4 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition"
         style="background:linear-gradient(135deg,#0f766e,#14b8a6);">Buat Pengaduan</a>
    </div>

    <?php else: ?>

    <div id="cardGrid" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
      <?php foreach($rows as $row):
        $status   = $row['status'];
        $badgeBg  = match($status) { 'Selesai' => 'bg-green-100 text-green-700', 'Proses' => 'bg-orange-100 text-orange-700', default => 'bg-yellow-100 text-yellow-700' };
        $dot      = match($status) { 'Selesai' => 'bg-green-500', 'Proses' => 'bg-orange-500', default => 'bg-yellow-500' };
        $topBar   = match($status) { 'Selesai' => 'bg-green-500', 'Proses' => 'bg-orange-400', default => 'bg-yellow-400' };

        // Progres perbaikan
        $progres  = match($status) { 'Selesai' => 100, 'Proses' => 50, default => 10 };
        $progresColor = match($status) { 'Selesai' => 'bg-green-500', 'Proses' => 'bg-orange-400', default => 'bg-yellow-400' };
        $progresLabel = match($status) {
          'Selesai' => 'Perbaikan selesai',
          'Proses'  => 'Sedang diperbaiki',
          default   => 'Menunggu ditindaklanjuti'
        };

        // Timeline steps
        $steps = [
          ['label' => 'Laporan Diterima', 'done' => true],
          ['label' => 'Sedang Diproses',  'done' => in_array($status, ['Proses','Selesai'])],
          ['label' => 'Selesai',          'done' => $status === 'Selesai'],
        ];
      ?>
      <div class="card-item bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow"
           data-status="<?= $status ?>">
        <div class="h-1 <?= $topBar ?>"></div>

        <div class="p-5">
          <!-- Header -->
          <div class="flex items-start justify-between mb-3">
            <div>
              <p class="text-xs text-gray-400 font-medium mb-0.5">NIS</p>
              <p class="font-bold text-gray-800"><?= htmlspecialchars($row['nis']) ?></p>
            </div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold <?= $badgeBg ?>">
              <span class="w-1.5 h-1.5 rounded-full <?= $dot ?> <?= $status==='Menunggu' ? 'animate-pulse' : '' ?>"></span>
              <?= $status ?>
            </span>
          </div>

          <!-- Info -->
          <div class="space-y-1.5 mb-3">
            <div class="flex items-center gap-2">
              <svg class="w-3.5 h-3.5 text-teal-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
              </svg>
              <span class="text-xs bg-teal-50 text-teal-700 font-medium px-2 py-0.5 rounded-lg"><?= htmlspecialchars($row['ket_kategori']) ?></span>
            </div>
            <div class="flex items-center gap-2">
              <svg class="w-3.5 h-3.5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
              </svg>
              <span class="text-xs text-gray-600"><?= htmlspecialchars($row['lokasi']) ?></span>
            </div>
            <div class="flex items-center gap-2">
              <svg class="w-3.5 h-3.5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
              </svg>
              <span class="text-xs text-gray-500"><?= date('d M Y', strtotime($row['created_at'])) ?></span>
            </div>
          </div>

          <!-- Keterangan -->
          <div class="bg-gray-50 rounded-xl p-3 mb-3">
            <p class="text-xs text-gray-500 leading-relaxed">
              <?= htmlspecialchars(mb_strimwidth($row['ket'], 0, 90, '...')) ?>
            </p>
          </div>

          <!-- ===== PROGRES PERBAIKAN ===== -->
          <div class="mb-3">
            <div class="flex items-center justify-between mb-1.5">
              <p class="text-xs font-semibold text-gray-700">Progres Perbaikan</p>
              <span class="text-xs font-bold text-gray-600"><?= $progres ?>%</span>
            </div>
            <!-- Bar -->
            <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
              <div class="progress-bar h-2 rounded-full <?= $progresColor ?>" style="width: <?= $progres ?>%"></div>
            </div>
            <p class="text-xs text-gray-400 mt-1"><?= $progresLabel ?></p>
          </div>

          <!-- ===== TIMELINE ===== -->
          <div class="flex items-center gap-0 mb-3">
            <?php foreach($steps as $i => $step): ?>
            <div class="flex items-center <?= $i < count($steps)-1 ? 'flex-1' : '' ?>">
              <div class="flex flex-col items-center">
                <div class="w-6 h-6 rounded-full flex items-center justify-center flex-shrink-0
                            <?= $step['done'] ? 'bg-teal-500' : 'bg-gray-200' ?>">
                  <?php if($step['done']): ?>
                  <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                  </svg>
                  <?php else: ?>
                  <span class="w-2 h-2 rounded-full bg-gray-400"></span>
                  <?php endif; ?>
                </div>
                <p class="text-xs text-center mt-1 leading-tight <?= $step['done'] ? 'text-teal-700 font-semibold' : 'text-gray-400' ?>" style="font-size:10px;width:60px;">
                  <?= $step['label'] ?>
                </p>
              </div>
              <?php if($i < count($steps)-1): ?>
              <div class="flex-1 h-0.5 mb-4 <?= $step['done'] && $steps[$i+1]['done'] ? 'bg-teal-400' : 'bg-gray-200' ?>"></div>
              <?php endif; ?>
            </div>
            <?php endforeach; ?>
          </div>

          <!-- Feedback -->
          <?php if(!empty($row['feedback'])): ?>
          <div class="bg-teal-50 border border-teal-100 rounded-xl p-3">
            <p class="text-xs font-semibold text-teal-700 mb-1 flex items-center gap-1">
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
              </svg>
              Umpan Balik Admin
              <?php if($row['tgl_update']): ?>
              <span class="ml-auto text-teal-400 font-normal" style="font-size:10px;"><?= date('d M Y', strtotime($row['tgl_update'])) ?></span>
              <?php endif; ?>
            </p>
            <p class="text-xs text-teal-700"><?= htmlspecialchars($row['feedback']) ?></p>
          </div>
          <?php endif; ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <div id="emptyFilter" class="hidden bg-white rounded-2xl shadow-sm p-12 text-center">
      <p class="text-gray-500 font-medium">Tidak ada pengaduan dengan filter ini</p>
    </div>

    <p class="text-center text-gray-400 text-xs mt-6" id="counter">
      Menampilkan <?= count($rows) ?> pengaduan
    </p>

    <?php endif; // end else (NIS diisi) ?>
  </div>

  <script>
    let activeStatus = '';

    function filterStatus(status) {
      activeStatus = status;
      applyFilter();
      document.querySelectorAll('.filter-btn').forEach(btn => {
        const s = btn.dataset.status;
        const colors = {
          '': 'border-teal-500 bg-teal-50 text-teal-700',
          'Menunggu': 'border-yellow-400 bg-yellow-50 text-yellow-700',
          'Proses': 'border-orange-400 bg-orange-50 text-orange-700',
          'Selesai': 'border-green-400 bg-green-50 text-green-700',
        };
        btn.className = 'filter-btn text-xs font-semibold px-4 py-2 rounded-xl border-2 transition ';
        btn.className += s === status ? colors[s] : 'border-gray-200 text-gray-500 hover:border-gray-300 hover:bg-gray-50';
      });
    }

    function applyFilter() {
      const q = document.getElementById('searchInput').value.toLowerCase();
      const cards = document.querySelectorAll('.card-item');
      let visible = 0;
      cards.forEach(card => {
        const show = (!activeStatus || card.dataset.status === activeStatus) &&
                     (!q || card.textContent.toLowerCase().includes(q));
        card.style.display = show ? '' : 'none';
        if(show) visible++;
      });
      const empty = document.getElementById('emptyFilter');
      const counter = document.getElementById('counter');
      if(empty) empty.classList.toggle('hidden', visible > 0);
      if(counter) counter.textContent = `Menampilkan ${visible} pengaduan`;
    }

    document.getElementById('searchInput').addEventListener('input', applyFilter);
  </script>
</body>
</html>
