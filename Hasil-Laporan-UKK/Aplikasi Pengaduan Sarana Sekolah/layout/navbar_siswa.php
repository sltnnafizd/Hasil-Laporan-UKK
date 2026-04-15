<?php
// Tentukan halaman aktif berdasarkan path
$currentPath = $_SERVER['PHP_SELF'];
$isHistori = strpos($currentPath, 'histori') !== false;
$isAbout   = strpos($currentPath, 'about') !== false;
$isIndex   = !$isHistori && !$isAbout;

// Path prefix (siswa/ butuh ../ untuk root)
$prefix = strpos($currentPath, '/siswa/') !== false ? '../' : '';
?>

<!-- ===== OVERLAY ===== -->
<div id="nav-overlay" onclick="closeNav()"
     class="fixed inset-0 bg-black bg-opacity-50 z-40 opacity-0 pointer-events-none transition-opacity duration-300"></div>

<!-- ===== SIDEBAR ===== -->
<aside id="nav-sidebar"
       class="fixed top-0 left-0 h-full z-50 flex flex-col -translate-x-full transition-transform duration-300 ease-in-out shadow-2xl"
       style="width:270px; background: linear-gradient(160deg,#042f2e 0%,#0d5c55 55%,#0f766e 100%);">

  <!-- Deco -->
  <div class="absolute top-0 right-0 w-44 h-44 rounded-full pointer-events-none opacity-5"
       style="background:radial-gradient(circle,#14b8a6,transparent);transform:translate(35%,-35%);"></div>

  <!-- Header -->
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
    <button onclick="closeNav()" class="text-teal-300 hover:text-white transition p-1">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
      </svg>
    </button>
  </div>

  <div class="mx-5 h-px bg-white opacity-10 mb-3"></div>

  <!-- Nav -->
  <nav class="flex-1 px-3 space-y-0.5">
    <p class="px-3 pt-1 pb-2 text-teal-400 text-xs font-semibold uppercase tracking-widest">Menu</p>

    <a href="<?= $prefix ?>index.php"
       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition
              <?= $isIndex ? 'bg-white bg-opacity-15 text-white font-semibold' : 'text-teal-100 hover:bg-white hover:bg-opacity-10 hover:text-white' ?>">
      <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
      </svg>
      Form Pengaduan
      <?php if($isIndex): ?><span class="ml-auto w-1.5 h-1.5 rounded-full bg-teal-300"></span><?php endif; ?>
    </a>

    <a href="<?= $prefix ?>siswa/histori.php"
       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition
              <?= $isHistori ? 'bg-white bg-opacity-15 text-white font-semibold' : 'text-teal-100 hover:bg-white hover:bg-opacity-10 hover:text-white' ?>">
      <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
      </svg>
      Histori Pengaduan
      <?php if($isHistori): ?><span class="ml-auto w-1.5 h-1.5 rounded-full bg-teal-300"></span><?php endif; ?>
    </a>

    <a href="<?= $prefix ?>about.php"
       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition
              <?= $isAbout ? 'bg-white bg-opacity-15 text-white font-semibold' : 'text-teal-100 hover:bg-white hover:bg-opacity-10 hover:text-white' ?>">
      <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
      </svg>
      About
      <?php if($isAbout): ?><span class="ml-auto w-1.5 h-1.5 rounded-full bg-teal-300"></span><?php endif; ?>
    </a>

    <div class="py-2"><div class="h-px bg-white opacity-10"></div></div>
    <p class="px-3 pb-2 text-teal-400 text-xs font-semibold uppercase tracking-widest">Admin</p>

    <a href="<?= $prefix ?>login.php"
       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-teal-100 hover:bg-white hover:bg-opacity-10 hover:text-white transition">
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
<nav class="sticky top-0 z-30 shadow-lg" style="background:linear-gradient(135deg,#042f2e 0%,#0f766e 60%,#14b8a6 100%);">
  <div class="max-w-6xl mx-auto px-4 py-3.5 flex items-center justify-between">
    <div class="flex items-center gap-3">
      <button onclick="openNav()"
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

    <!-- Nav links kanan -->
    <div class="flex items-center gap-1">
      <a href="<?= $prefix ?>index.php"
         class="hidden sm:flex items-center gap-1.5 text-sm font-medium px-3 py-2 rounded-lg transition
                <?= $isIndex ? 'text-white bg-white bg-opacity-20' : 'text-teal-100 hover:text-white hover:bg-white hover:bg-opacity-10' ?>">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
        </svg>
        Form
      </a>
      <a href="<?= $prefix ?>siswa/histori.php"
         class="hidden sm:flex items-center gap-1.5 text-sm font-medium px-3 py-2 rounded-lg transition
                <?= $isHistori ? 'text-white bg-white bg-opacity-20' : 'text-teal-100 hover:text-white hover:bg-white hover:bg-opacity-10' ?>">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
        Histori
      </a>
      <a href="<?= $prefix ?>login.php"
         class="flex items-center gap-1.5 bg-white bg-opacity-20 hover:bg-opacity-30 text-white text-sm font-semibold px-4 py-2 rounded-xl transition ml-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
        </svg>
        Admin
      </a>
    </div>
  </div>
</nav>

<script>
  function openNav() {
    document.getElementById('nav-sidebar').classList.remove('-translate-x-full');
    const ov = document.getElementById('nav-overlay');
    ov.classList.remove('opacity-0','pointer-events-none');
    ov.classList.add('opacity-100');
  }
  function closeNav() {
    document.getElementById('nav-sidebar').classList.add('-translate-x-full');
    const ov = document.getElementById('nav-overlay');
    ov.classList.add('opacity-0','pointer-events-none');
    ov.classList.remove('opacity-100');
  }
</script>
