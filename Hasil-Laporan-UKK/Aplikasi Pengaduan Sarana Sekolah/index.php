<?php include "config/koneksi.php"; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pengaduan Sarana Sekolah</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    * { font-family: 'Inter', sans-serif; }
    .grad { background: linear-gradient(135deg, #042f2e 0%, #0f766e 60%, #14b8a6 100%); }
    .input-field {
      width: 100%; padding: 11px 14px; border: 2px solid #e5e7eb;
      border-radius: 12px; font-size: 14px; transition: all 0.2s;
      outline: none; background: #f9fafb; color: #111827;
    }
    .input-field:focus {
      border-color: #14b8a6; background: #fff;
      box-shadow: 0 0 0 4px rgba(20,184,166,0.1);
    }

    /* Toast notification */
    #toast-overlay {
      position: fixed; inset: 0; z-index: 9998;
      display: flex; align-items: center; justify-content: center;
      background: rgba(0,0,0,0.4);
      opacity: 0; pointer-events: none;
      transition: opacity 0.3s ease;
    }
    #toast-overlay.show { opacity: 1; pointer-events: all; }

    #toast {
      position: relative; z-index: 9999;
      background: #fff; border-radius: 24px;
      padding: 40px 36px 32px;
      box-shadow: 0 30px 80px rgba(0,0,0,0.2);
      text-align: center;
      width: 340px;
      transform: scale(0.7) translateY(40px);
      opacity: 0;
      transition: transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.3s ease;
    }
    #toast.show { transform: scale(1) translateY(0); opacity: 1; }

    .toast-icon-wrap {
      width: 72px; height: 72px; border-radius: 50%; margin: 0 auto 16px;
      background: linear-gradient(135deg, #14b8a6, #06b6d4);
      display: flex; align-items: center; justify-content: center;
      box-shadow: 0 8px 24px rgba(20,184,166,0.4);
      animation: popIn 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) 0.2s both;
    }
    @keyframes popIn {
      from { transform: scale(0); }
      to   { transform: scale(1); }
    }
    .toast-checkmark {
      stroke-dasharray: 50;
      stroke-dashoffset: 50;
      animation: drawCheck 0.5s ease 0.5s forwards;
    }
    @keyframes drawCheck {
      to { stroke-dashoffset: 0; }
    }
    .toast-progress {
      height: 4px; background: #e5e7eb; border-radius: 99px;
      overflow: hidden; margin-top: 20px;
    }
    .toast-progress-bar {
      height: 100%; border-radius: 99px;
      background: linear-gradient(90deg, #0f766e, #14b8a6);
      animation: shrink 4s linear forwards;
    }
    @keyframes shrink { from { width: 100%; } to { width: 0%; } }

    /* Confetti */
    .confetti-piece {
      position: fixed; width: 8px; height: 8px; border-radius: 2px;
      animation: confettiFall 1.2s ease-in forwards;
      z-index: 10000;
    }
    @keyframes confettiFall {
      0%   { transform: translateY(-20px) rotate(0deg); opacity: 1; }
      100% { transform: translateY(100vh) rotate(720deg); opacity: 0; }
    }
  </style>
</head>
<body class="min-h-screen bg-teal-50">

<!-- ===== OVERLAY ===== -->
<div id="overlay" onclick="closeSidebar()"
     class="fixed inset-0 bg-black bg-opacity-50 z-40 opacity-0 pointer-events-none transition-opacity duration-300"></div>

<!-- ===== SIDEBAR ===== -->
<aside id="sidebar"
       class="fixed top-0 left-0 h-full w-68 z-50 flex flex-col -translate-x-full transition-transform duration-300 ease-in-out shadow-2xl"
       style="width:270px; background: linear-gradient(160deg,#042f2e 0%,#0d5c55 55%,#0f766e 100%);">

  <!-- Deco blob -->
  <div class="absolute top-0 right-0 w-44 h-44 rounded-full pointer-events-none opacity-5"
       style="background:radial-gradient(circle,#14b8a6,transparent);transform:translate(35%,-35%);"></div>

  <!-- Header sidebar -->
  <div class="flex items-center justify-between px-5 pt-6 pb-4">
    <div class="flex items-center gap-3">
      <div class="w-10 h-10 rounded-xl flex items-center justify-center shadow"
           style="background:linear-gradient(135deg,#14b8a6,#06b6d4);">
        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
        </svg>
      </div>
      <div>
        <p class="text-white font-bold text-sm">Pengaduan Sarana</p>
        <p class="text-teal-300 text-xs">Fasilitas Sekolah</p>
      </div>
    </div>
    <button onclick="closeSidebar()" class="text-teal-300 hover:text-white transition p-1">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
      </svg>
    </button>
  </div>

  <div class="mx-5 h-px bg-white opacity-10 mb-3"></div>

  <!-- Nav items -->
  <nav class="flex-1 px-3 space-y-0.5">
    <p class="px-3 pt-1 pb-2 text-teal-400 text-xs font-semibold uppercase tracking-widest">Menu</p>

    <a href="index.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold text-white bg-white bg-opacity-15">
      <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
      </svg>
      Form Pengaduan
      <span class="ml-auto w-1.5 h-1.5 rounded-full bg-teal-300"></span>
    </a>

    <a href="siswa/histori.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-teal-100 hover:bg-white hover:bg-opacity-10 hover:text-white transition">
      <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
      </svg>
      Histori Pengaduan
    </a>

    <a href="about.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-teal-100 hover:bg-white hover:bg-opacity-10 hover:text-white transition">
      <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
      </svg>
      About
    </a>

    <div class="py-2"><div class="h-px bg-white opacity-10"></div></div>
    <p class="px-3 pb-2 text-teal-400 text-xs font-semibold uppercase tracking-widest">Admin</p>

    <a href="login.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-teal-100 hover:bg-white hover:bg-opacity-10 hover:text-white transition">
      <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
      </svg>
      Login Admin
    </a>
  </nav>

  <div class="px-5 py-4 border-t border-white border-opacity-10">
    <p class="text-teal-400 text-xs text-center">© <?= date('Y') ?> Pengaduan Sarana Sekolah</p>
  </div>
</aside>

<!-- ===== NAVBAR ===== -->
<nav class="grad sticky top-0 z-30 shadow-lg">
  <div class="max-w-3xl mx-auto px-4 py-3 flex items-center justify-between">

    <!-- Kiri: hamburger + brand -->
    <div class="flex items-center gap-3">
      <button onclick="openSidebar()"
              class="w-9 h-9 flex items-center justify-center rounded-xl bg-white bg-opacity-15 hover:bg-opacity-25 text-white transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
      </button>
      <div>
        <p class="text-white font-bold text-sm leading-tight">Pengaduan Sarana</p>
        <p class="text-teal-200 text-xs hidden sm:block">Sistem Pelaporan Fasilitas Sekolah</p>
      </div>
    </div>

    <!-- Kanan: links -->
    <div class="flex items-center gap-1">
      <a href="siswa/histori.php"
         class="hidden sm:flex items-center gap-1.5 text-teal-100 hover:text-white text-sm font-medium px-3 py-2 rounded-lg hover:bg-white hover:bg-opacity-10 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
        Histori
      </a>
      <a href="login.php"
         class="flex items-center gap-1.5 bg-white bg-opacity-20 hover:bg-opacity-30 text-white text-sm font-semibold px-4 py-2 rounded-xl transition ml-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
        </svg>
        Admin
      </a>
    </div>
  </div>
</nav>

<!-- ===== HERO ===== -->
<div class="grad py-10 px-4">
  <div class="max-w-xl mx-auto text-center">
    <div class="inline-flex items-center gap-2 bg-white bg-opacity-15 text-white text-xs font-medium px-4 py-1.5 rounded-full mb-4">
      <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
      Sistem aktif & siap menerima laporan
    </div>
    <h2 class="text-2xl sm:text-3xl font-bold text-white mb-2">Laporkan Kerusakan Fasilitas</h2>
    <p class="text-teal-100 text-sm">Sampaikan pengaduan sarana sekolah kamu dengan mudah. Kami akan segera menindaklanjuti.</p>
  </div>
</div>

<!-- ===== FORM CARD ===== -->
<div class="max-w-xl mx-auto px-4 -mt-5 pb-12">
  <div class="bg-white rounded-2xl shadow-xl overflow-hidden">

    <!-- Top accent bar -->
    <div class="h-1" style="background:linear-gradient(90deg,#0f766e,#14b8a6,#06b6d4);"></div>

    <div class="p-7">

      <?php if(isset($_GET['error'])): ?>
      <div class="mb-5 flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        Terjadi kesalahan. Pastikan semua field terisi dengan benar.
      </div>
      <?php endif; ?>

      <!-- Form header -->
      <div class="flex items-center gap-3 mb-6">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
             style="background:linear-gradient(135deg,#ccfbf1,#99f6e4);">
          <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
          </svg>
        </div>
        <div>
          <h3 class="font-bold text-gray-800 text-base">Form Pengaduan</h3>
          <p class="text-gray-400 text-xs">Isi semua field bertanda <span class="text-red-500">*</span> dengan lengkap</p>
        </div>
      </div>

      <form action="proses/simpan_aspirasi.php" method="POST" class="space-y-4">

        <!-- NIS -->
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-1.5">
            NIS <span class="text-red-500">*</span>
          </label>
          <input type="text" name="nis" class="input-field" placeholder="Contoh: 2324123456" required>
        </div> 

        <!-- Kategori -->
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-1.5">
            Kategori Kerusakan <span class="text-red-500">*</span>
          </label>
          <select name="id_kategori" class="input-field" required>
            <option value="">-- Pilih Kategori --</option>
            <?php
            $data = mysqli_query($conn,"SELECT * FROM kategori");
            while($d = mysqli_fetch_array($data)):
            ?>
            <option value="<?= $d['id_kategori'] ?>"><?= htmlspecialchars($d['ket_kategori']) ?></option>
            <?php endwhile; ?>
          </select>
        </div>

        <!-- Lokasi -->
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-1.5">
            Lokasi Kerusakan <span class="text-red-500">*</span>
          </label>
          <select name="lokasi" class="input-field" required>
            <option value="">-- Pilih Lokasi --</option>
            <optgroup label="Laboratorium">
              <option value="Laboratorium 1">Laboratorium 1</option>
              <option value="Laboratorium 2">Laboratorium 2</option>
              <option value="Laboratorium 3">Laboratorium 3</option>
              <option value="Laboratorium 4">Laboratorium 4</option>
              <option value="Laboratorium 5">Laboratorium 5</option>
            </optgroup>
            <optgroup label="Ruang Kelas RPL">
              <option value="Kelas RPL 1">Kelas RPL 1</option>
              <option value="Kelas RPL 2">Kelas RPL 2</option>
            </optgroup>
            <optgroup label="Fasilitas Umum">
              <option value="Toilet / WC">Toilet / WC</option>
              <option value="Perpustakaan">Perpustakaan</option>
              <option value="Kantin">Kantin</option>
              <option value="Lapangan / Olahraga">Lapangan / Olahraga</option>
              <option value="Mushola">Mushola</option>
              <option value="Ruang Guru">Ruang Guru</option>
              <option value="Ruang TU">Ruang TU</option>
              <option value="Parkiran">Parkiran</option>
              <option value="Koridor / Lorong">Koridor / Lorong</option>
              <option value="Lainnya">Lainnya</option>
            </optgroup>
          </select>
        </div>

        <!-- Keterangan -->
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-1.5">
            Keterangan Detail <span class="text-red-500">*</span>
          </label>
          <textarea name="ket" rows="4" class="input-field" style="resize:none;"
                    placeholder="Jelaskan kerusakan secara detail..." required></textarea>
        </div>

        <!-- Submit -->
        <button type="submit"
                class="w-full flex items-center justify-center gap-2 text-white font-semibold py-3 rounded-xl transition-all duration-200 hover:-translate-y-0.5"
                style="background:linear-gradient(135deg,#0f766e,#14b8a6); box-shadow:0 4px 15px rgba(20,184,166,0.35);">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
          </svg>
          Kirim Pengaduan
        </button>
      </form>

      <!-- Footer link -->
      <div class="mt-5 pt-5 border-t border-gray-100 text-center">
        <a href="siswa/histori.php"
           class="inline-flex items-center gap-2 text-teal-600 hover:text-teal-700 font-semibold text-sm transition">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
          </svg>
          Cek Status Pengaduan Saya
        </a>
      </div>
    </div>
  </div>
</div>

<!-- ===== TOAST NOTIFICATION ===== -->
<div id="toast-overlay">
  <div id="toast">
    <div class="toast-icon-wrap">
      <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <polyline class="toast-checkmark" points="20 6 9 17 4 12"/>
      </svg>
    </div>
    <h3 style="font-size:18px;font-weight:800;color:#111827;margin:0 0 6px;">Pengaduan Terkirim! 🎉</h3>
    <p style="font-size:13px;color:#6b7280;margin:0;line-height:1.5;">Laporan kamu sudah kami terima.<br>Pantau status di halaman <strong>Histori</strong>.</p>
    <div class="toast-progress"><div class="toast-progress-bar"></div></div>
    <button onclick="closeToast()"
            style="margin-top:16px;background:linear-gradient(135deg,#0f766e,#14b8a6);color:white;border:none;padding:10px 28px;border-radius:12px;font-size:13px;font-weight:600;cursor:pointer;width:100%;">
      Oke, Mengerti!
    </button>
  </div>
</div>

<script>
  function openSidebar() {
    document.getElementById('sidebar').classList.remove('-translate-x-full');
    const ov = document.getElementById('overlay');
    ov.classList.remove('opacity-0','pointer-events-none');
    ov.classList.add('opacity-100');
  }
  function closeSidebar() {
    document.getElementById('sidebar').classList.add('-translate-x-full');
    const ov = document.getElementById('overlay');
    ov.classList.add('opacity-0','pointer-events-none');
    ov.classList.remove('opacity-100');
  }

  function closeToast() {
    document.getElementById('toast').classList.remove('show');
    document.getElementById('toast-overlay').classList.remove('show');
  }

  function launchConfetti() {
    const colors = ['#14b8a6','#06b6d4','#0f766e','#34d399','#fbbf24','#f97316'];
    for(let i = 0; i < 60; i++){
      const el = document.createElement('div');
      el.className = 'confetti-piece';
      el.style.left = Math.random() * 100 + 'vw';
      el.style.top = '-10px';
      el.style.background = colors[Math.floor(Math.random() * colors.length)];
      el.style.animationDelay = (Math.random() * 0.8) + 's';
      el.style.animationDuration = (0.8 + Math.random() * 0.8) + 's';
      el.style.width = (6 + Math.random() * 8) + 'px';
      el.style.height = (6 + Math.random() * 8) + 'px';
      document.body.appendChild(el);
      setTimeout(() => el.remove(), 2000);
    }
  }

  <?php if(isset($_GET['success'])): ?>
  window.addEventListener('load', () => {
    setTimeout(() => {
      document.getElementById('toast-overlay').classList.add('show');
      document.getElementById('toast').classList.add('show');
      launchConfetti();
      setTimeout(closeToast, 5000);
    }, 300);
  });
  <?php endif; ?>
</script>
</body>
</html>
