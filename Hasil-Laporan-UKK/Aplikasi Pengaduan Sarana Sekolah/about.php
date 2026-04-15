<?php include "config/koneksi.php"; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About — Pengaduan Sarana</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Inter', sans-serif; }
    .gradient-bg { background: linear-gradient(135deg, #042f2e 0%, #0f766e 60%, #14b8a6 100%); }
  </style>
</head>
<body class="min-h-screen" style="background: #f0fdf9;">

<?php include "layout/navbar_siswa.php"; ?>

  <!-- Hero -->
  <div class="gradient-bg py-12 px-4">
    <div class="max-w-2xl mx-auto text-center">
      <div class="w-20 h-20 rounded-2xl mx-auto mb-4 flex items-center justify-center"
           style="background: rgba(255,255,255,0.15);">
        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
      </div>
      <h2 class="text-3xl font-bold text-white mb-2">Tentang Aplikasi</h2>
      <p class="text-teal-100 text-sm">Kenali lebih jauh sistem pengaduan sarana sekolah ini</p>
    </div>
  </div>

  <div class="max-w-3xl mx-auto px-4 -mt-6 pb-12">

    <!-- App Info -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-6">
      <div class="h-1.5" style="background: linear-gradient(90deg, #0f766e, #14b8a6, #06b6d4);"></div>
      <div class="p-8">
        <h3 class="text-xl font-bold text-gray-800 mb-2">Aplikasi Pengaduan Sarana Sekolah</h3>
        <span class="inline-block bg-teal-100 text-teal-700 text-xs font-semibold px-3 py-1 rounded-full mb-4">Versi 1.0.0</span>
        <p class="text-gray-600 text-sm leading-relaxed">
          Aplikasi ini dirancang untuk memudahkan siswa dalam melaporkan kerusakan atau masalah pada fasilitas dan sarana sekolah secara digital. Setiap laporan akan ditindaklanjuti oleh admin dan siswa dapat memantau status penanganannya secara langsung.
        </p>
      </div>
    </div>

    <!-- Cara Penggunaan -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
      <h3 class="font-bold text-gray-800 mb-5 flex items-center gap-2">
        <span class="w-7 h-7 rounded-lg bg-teal-100 flex items-center justify-center">
          <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
          </svg>
        </span>
        Cara Penggunaan
      </h3>
      <div class="space-y-4">
        <?php
        $steps = [
          ['no'=>'1', 'judul'=>'Isi Form Pengaduan', 'desc'=>'Masukkan NIS, pilih kategori kerusakan, lokasi, dan keterangan detail di halaman utama.'],
          ['no'=>'2', 'judul'=>'Kirim Laporan',       'desc'=>'Klik tombol "Kirim Pengaduan". Laporan kamu akan langsung masuk ke sistem.'],
          ['no'=>'3', 'judul'=>'Pantau Status',        'desc'=>'Buka halaman Histori untuk melihat status penanganan dan feedback dari admin.'],
        ];
        foreach($steps as $s): ?>
        <div class="flex items-start gap-4">
          <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-sm font-bold flex-shrink-0"
               style="background: linear-gradient(135deg, #0f766e, #14b8a6);">
            <?= $s['no'] ?>
          </div>
          <div>
            <p class="font-semibold text-gray-800 text-sm"><?= $s['judul'] ?></p>
            <p class="text-gray-500 text-xs mt-0.5 leading-relaxed"><?= $s['desc'] ?></p>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Fitur -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
      <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
        <span class="w-7 h-7 rounded-lg bg-teal-100 flex items-center justify-center">
          <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
          </svg>
        </span>
        Fitur Utama
      </h3>
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <?php
        $fitur = [
          ['icon'=>'📋', 'judul'=>'Form Pengaduan Mudah',  'desc'=>'Isi dan kirim laporan dalam hitungan detik'],
          ['icon'=>'🔍', 'judul'=>'Pantau Status Real-time','desc'=>'Lihat perkembangan penanganan kapan saja'],
          ['icon'=>'💬', 'judul'=>'Feedback Admin',         'desc'=>'Terima tanggapan langsung dari admin'],
          ['icon'=>'🗂️', 'judul'=>'Kategori Terstruktur',   'desc'=>'Laporan dikelompokkan berdasarkan jenis kerusakan'],
        ];
        foreach($fitur as $f): ?>
        <div class="flex items-start gap-3 p-3 rounded-xl bg-gray-50 hover:bg-teal-50 transition">
          <span class="text-xl flex-shrink-0"><?= $f['icon'] ?></span>
          <div>
            <p class="font-semibold text-gray-800 text-sm"><?= $f['judul'] ?></p>
            <p class="text-gray-500 text-xs mt-0.5"><?= $f['desc'] ?></p>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Footer info -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center justify-between flex-wrap gap-4">
      <div>
        <p class="font-semibold text-gray-800 text-sm">Dikembangkan oleh Tim Pengembang</p>
        <p class="text-teal-600 text-xs mt-0.5">© <?= date('Y') ?> Sistem Pengaduan Sarana Sekolah</p>
      </div>
      <a href="index.php"
         class="inline-flex items-center gap-2 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition"
         style="background: linear-gradient(135deg, #0f766e, #14b8a6);">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali ke Form
      </a>
    </div>

  </div>
</body>
</html>
