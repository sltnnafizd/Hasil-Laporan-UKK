<?php
session_start();
if(!isset($_SESSION['admin'])){ header("Location: ../login.php"); exit; }
include "../config/koneksi.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if(!$id){ header("Location: data_aspirasi.php"); exit; }

// Ambil data pengaduan
$q = mysqli_query($conn,"
    SELECT ia.*, k.ket_kategori,
           COALESCE(a.status,'Menunggu') as status,
           a.feedback, a.updated_at
    FROM input_aspirasi ia
    LEFT JOIN kategori k ON ia.id_kategori = k.id_kategori
    LEFT JOIN aspirasi a ON ia.id_pelaporan = a.id_pelaporan
    WHERE ia.id_pelaporan = $id
");
if(mysqli_num_rows($q) === 0){ header("Location: data_aspirasi.php"); exit; }
$d = mysqli_fetch_assoc($q);

$pesan = '';
$pesanType = '';

// Handle POST
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $status   = mysqli_real_escape_string($conn, $_POST['status']);
    $feedback = mysqli_real_escape_string($conn, trim($_POST['feedback']));

    // Cek apakah sudah ada record di tabel aspirasi
    $cek = mysqli_query($conn,"SELECT id FROM aspirasi WHERE id_pelaporan=$id");
    if(mysqli_num_rows($cek) > 0){
        // UPDATE
        mysqli_query($conn,"UPDATE aspirasi SET status='$status', feedback='$feedback', updated_at=NOW() WHERE id_pelaporan=$id");
    } else {
        // INSERT
        mysqli_query($conn,"INSERT INTO aspirasi (id_pelaporan, id_kategori, status, feedback) VALUES ($id, {$d['id_kategori']}, '$status', '$feedback')");
    }

    // Catat ke histori
    $statusLama = mysqli_real_escape_string($conn, $d['status']);
    $admin      = mysqli_real_escape_string($conn, $_SESSION['admin']);
    mysqli_query($conn,"INSERT INTO histori (id_pelaporan, status_lama, status_baru, feedback, diubah_oleh) VALUES ($id, '$statusLama', '$status', '$feedback', '$admin')");

    header("Location: feedback.php?id=$id&saved=1");
    exit;
}

// Badge config
$badge = match($d['status']) {
    'Selesai' => 'bg-green-100 text-green-700',
    'Proses'  => 'bg-orange-100 text-orange-700',
    default   => 'bg-yellow-100 text-yellow-700',
};
$progres = match($d['status']) { 'Selesai' => 100, 'Proses' => 50, default => 10 };
$progresColor = match($d['status']) { 'Selesai' => 'bg-green-500', 'Proses' => 'bg-orange-400', default => 'bg-yellow-400' };
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Proses Pengaduan — Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>body { font-family: 'Inter', sans-serif; background: #f0fdf9; }</style>
</head>
<body class="flex min-h-screen">

  <?php include '../layout/sidebar.php'; ?>

  <main class="flex-1 overflow-auto">

    <!-- Topbar -->
    <div class="bg-white border-b border-gray-200 px-8 py-4 sticky top-0 z-10 flex items-center gap-3">
      <a href="data_aspirasi.php" class="text-gray-400 hover:text-gray-600 transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
      </a>
      <div>
        <h1 class="text-xl font-bold text-gray-800">Proses Pengaduan</h1>
        <p class="text-gray-500 text-sm">ID #<?= $id ?> — <?= htmlspecialchars($d['nis']) ?></p>
      </div>
    </div>

    <div class="p-8 max-w-4xl">

      <?php if(isset($_GET['saved'])): ?>
      <div class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-2xl text-sm">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        Status dan umpan balik berhasil disimpan.
      </div>
      <?php endif; ?>

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Kiri: Detail Pengaduan -->
        <div class="space-y-4">

          <!-- Info Card -->
          <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="h-1" style="background:linear-gradient(90deg,#0f766e,#14b8a6,#06b6d4);"></div>
            <div class="p-6">
              <div class="flex items-center justify-between mb-4">
                <h2 class="font-bold text-gray-800">Detail Pengaduan</h2>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold <?= $badge ?>">
                  <?= $d['status'] ?>
                </span>
              </div>

              <div class="space-y-3">
                <div class="flex gap-3">
                  <span class="text-xs text-gray-400 w-24 flex-shrink-0 pt-0.5">NIS</span>
                  <span class="text-sm font-semibold text-gray-800"><?= htmlspecialchars($d['nis']) ?></span>
                </div>
                <div class="flex gap-3">
                  <span class="text-xs text-gray-400 w-24 flex-shrink-0 pt-0.5">Kategori</span>
                  <span class="text-sm bg-teal-50 text-teal-700 font-medium px-2 py-0.5 rounded-lg"><?= htmlspecialchars($d['ket_kategori']) ?></span>
                </div>
                <div class="flex gap-3">
                  <span class="text-xs text-gray-400 w-24 flex-shrink-0 pt-0.5">Lokasi</span>
                  <span class="text-sm text-gray-700"><?= htmlspecialchars($d['lokasi']) ?></span>
                </div>
                <div class="flex gap-3">
                  <span class="text-xs text-gray-400 w-24 flex-shrink-0 pt-0.5">Tanggal</span>
                  <span class="text-sm text-gray-700"><?= date('d M Y, H:i', strtotime($d['created_at'])) ?></span>
                </div>
                <div class="flex gap-3">
                  <span class="text-xs text-gray-400 w-24 flex-shrink-0 pt-0.5">Keterangan</span>
                  <span class="text-sm text-gray-700 leading-relaxed"><?= nl2br(htmlspecialchars($d['ket'])) ?></span>
                </div>
              </div>
            </div>
          </div>

          <!-- Progres -->
          <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <h3 class="font-semibold text-gray-800 text-sm mb-3">Progres Penanganan</h3>
            <div class="w-full bg-gray-100 rounded-full h-2.5 mb-2">
              <div class="h-2.5 rounded-full <?= $progresColor ?>" style="width:<?= $progres ?>%;transition:width 0.8s ease;"></div>
            </div>
            <div class="flex justify-between text-xs text-gray-400">
              <span>Diterima</span>
              <span>Diproses</span>
              <span>Selesai</span>
            </div>

            <!-- Timeline -->
            <div class="flex items-center mt-4 gap-0">
              <?php
              $steps = [
                ['label'=>'Diterima', 'done'=>true],
                ['label'=>'Diproses', 'done'=>in_array($d['status'],['Proses','Selesai'])],
                ['label'=>'Selesai',  'done'=>$d['status']==='Selesai'],
              ];
              foreach($steps as $i => $step):
              ?>
              <div class="flex items-center <?= $i < 2 ? 'flex-1' : '' ?>">
                <div class="flex flex-col items-center">
                  <div class="w-7 h-7 rounded-full flex items-center justify-center <?= $step['done'] ? 'bg-teal-500' : 'bg-gray-200' ?>">
                    <?php if($step['done']): ?>
                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                    </svg>
                    <?php else: ?>
                    <span class="w-2 h-2 rounded-full bg-gray-400"></span>
                    <?php endif; ?>
                  </div>
                  <p class="text-xs mt-1 <?= $step['done'] ? 'text-teal-700 font-semibold' : 'text-gray-400' ?>"><?= $step['label'] ?></p>
                </div>
                <?php if($i < 2): ?>
                <div class="flex-1 h-0.5 mb-4 <?= $step['done'] && $steps[$i+1]['done'] ? 'bg-teal-400' : 'bg-gray-200' ?>"></div>
                <?php endif; ?>
              </div>
              <?php endforeach; ?>
            </div>
          </div>

        </div>

        <!-- Kanan: Form Update Status -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 h-fit">
          <h2 class="font-bold text-gray-800 mb-5 flex items-center gap-2">
            <span class="w-8 h-8 bg-teal-100 rounded-lg flex items-center justify-center">
              <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
              </svg>
            </span>
            Update Status & Umpan Balik
          </h2>

          <form method="POST" class="space-y-4">

            <!-- Status -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">Status Penanganan</label>
              <div class="grid grid-cols-3 gap-2">
                <?php foreach(['Menunggu','Proses','Selesai'] as $s):
                  $colors = match($s) {
                    'Selesai' => ['border-green-400 bg-green-50 text-green-700', 'border-gray-200 text-gray-500 hover:border-green-300'],
                    'Proses'  => ['border-orange-400 bg-orange-50 text-orange-700', 'border-gray-200 text-gray-500 hover:border-orange-300'],
                    default   => ['border-yellow-400 bg-yellow-50 text-yellow-700', 'border-gray-200 text-gray-500 hover:border-yellow-300'],
                  };
                  $isSelected = $d['status'] === $s;
                ?>
                <label class="cursor-pointer">
                  <input type="radio" name="status" value="<?= $s ?>" class="sr-only" <?= $isSelected ? 'checked' : '' ?>>
                  <div class="status-option border-2 rounded-xl py-2 text-center text-xs font-semibold transition
                              <?= $isSelected ? $colors[0] : $colors[1] ?>">
                    <?= $s ?>
                  </div>
                </label>
                <?php endforeach; ?>
              </div>
            </div>

            <!-- Feedback -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">Umpan Balik</label>
              <textarea name="feedback" rows="5"
                        class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-teal-400 focus:ring-2 focus:ring-teal-100 transition resize-none"
                        placeholder="Tulis umpan balik untuk siswa..."><?= htmlspecialchars($d['feedback'] ?? '') ?></textarea>
            </div>

            <button type="submit"
                    class="w-full flex items-center justify-center gap-2 text-white font-semibold py-3 rounded-xl transition hover:-translate-y-0.5"
                    style="background:linear-gradient(135deg,#0f766e,#14b8a6);box-shadow:0 4px 15px rgba(20,184,166,0.35);">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
              </svg>
              Simpan Perubahan
            </button>
          </form>

          <?php if($d['updated_at']): ?>
          <p class="text-xs text-gray-400 text-center mt-3">
            Terakhir diupdate: <?= date('d M Y, H:i', strtotime($d['updated_at'])) ?>
            oleh <span class="font-medium"><?= htmlspecialchars($_SESSION['admin']) ?></span>
          </p>
          <?php endif; ?>
        </div>

      </div>
    </div>
  </main>

  <script>
    // Radio button visual toggle
    document.querySelectorAll('input[name="status"]').forEach(radio => {
      radio.addEventListener('change', () => {
        document.querySelectorAll('.status-option').forEach(el => {
          el.className = 'status-option border-2 rounded-xl py-2 text-center text-xs font-semibold transition border-gray-200 text-gray-500';
        });
        const colors = {
          'Menunggu': 'border-yellow-400 bg-yellow-50 text-yellow-700',
          'Proses':   'border-orange-400 bg-orange-50 text-orange-700',
          'Selesai':  'border-green-400 bg-green-50 text-green-700',
        };
        radio.nextElementSibling.className = 'status-option border-2 rounded-xl py-2 text-center text-xs font-semibold transition ' + colors[radio.value];
      });
    });
  </script>
</body>
</html>
