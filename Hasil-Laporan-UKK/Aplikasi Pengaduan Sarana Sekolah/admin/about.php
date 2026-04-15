<?php
session_start();
if(!isset($_SESSION['admin'])){ header("Location: ../login.php"); exit; }
include "../config/koneksi.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About — Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>body { font-family: 'Inter', sans-serif; background: #f0fdf9; }</style>
</head>
<body class="flex min-h-screen">

  <?php include '../layout/sidebar.php'; ?>

  <main class="flex-1 overflow-auto">

    <!-- Topbar -->
    <div class="bg-white border-b border-gray-200 px-8 py-4 sticky top-0 z-10">
      <h1 class="text-xl font-bold text-gray-800">About</h1>
      <p class="text-gray-500 text-sm">Informasi aplikasi dan pengembang</p>
    </div>

    <div class="p-8 max-w-3xl">

      <!-- App Info Card -->
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
        <div class="h-2" style="background: linear-gradient(90deg, #0f766e, #14b8a6, #06b6d4);"></div>
        <div class="p-8 flex items-center gap-6">
          <div class="w-20 h-20 rounded-2xl flex items-center justify-center flex-shrink-0"
               style="background: linear-gradient(135deg, #14b8a6, #06b6d4);">
            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
          </div>
          <div>
            <h2 class="text-2xl font-bold text-gray-800">Aplikasi Pengaduan Sarana Sekolah</h2>
            <p class="text-teal-600 font-medium text-sm mt-1">Versi 1.0.0</p>
            <p class="text-gray-500 text-sm mt-2 leading-relaxed">
              Sistem informasi berbasis web untuk memudahkan siswa melaporkan kerusakan fasilitas dan sarana sekolah secara digital, cepat, dan terstruktur.
            </p>
          </div>
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
            ['icon'=>'📋', 'judul'=>'Form Pengaduan', 'desc'=>'Siswa dapat mengirim laporan kerusakan dengan mudah'],
            ['icon'=>'📊', 'judul'=>'Dashboard Admin', 'desc'=>'Pantau statistik pengaduan secara real-time'],
            ['icon'=>'🔄', 'judul'=>'Update Status', 'desc'=>'Admin dapat memperbarui status penanganan'],
            ['icon'=>'💬', 'judul'=>'Feedback', 'desc'=>'Admin dapat memberikan tanggapan ke pelapor'],
            ['icon'=>'🗂️', 'judul'=>'Kelola Kategori', 'desc'=>'Atur kategori jenis kerusakan fasilitas'],
            ['icon'=>'👤', 'judul'=>'Multi Admin', 'desc'=>'Dukungan lebih dari satu akun administrator'],
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

      <!-- Tech Stack -->
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
          <span class="w-7 h-7 rounded-lg bg-teal-100 flex items-center justify-center">
            <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
            </svg>
          </span>
          Teknologi
        </h3>
        <div class="flex flex-wrap gap-2">
          <?php
          $tech = ['PHP', 'MySQL', 'Tailwind CSS', 'HTML5', 'JavaScript', 'XAMPP'];
          foreach($tech as $t): ?>
          <span class="px-3 py-1.5 rounded-xl text-sm font-semibold bg-teal-50 text-teal-700 border border-teal-100">
            <?= $t ?>
          </span>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Developer -->
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
          <span class="w-7 h-7 rounded-lg bg-teal-100 flex items-center justify-center">
            <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
          </span>
          Pengembang
        </h3>
        <div class="flex items-center gap-4">
          <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-white text-xl font-bold flex-shrink-0"
               style="background: linear-gradient(135deg, #14b8a6, #06b6d4);">
            👨‍💻
          </div>
          <div>
            <p class="font-bold text-gray-800">Tim Pengembang</p>
            <p class="text-gray-500 text-sm">Sistem Informasi — Pengaduan Sarana Sekolah</p>
            <p class="text-teal-600 text-xs mt-1 font-medium">© <?= date('Y') ?> All rights reserved</p>
          </div>
        </div>
      </div>

    </div>
  </main>

</body>
</html>
