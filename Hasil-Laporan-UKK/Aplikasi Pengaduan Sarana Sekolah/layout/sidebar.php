<?php
$currentPage = basename($_SERVER['PHP_SELF']);
function navLink($href, $label, $icon, $current) {
    $isActive = basename($href) === $current;
    $base = "flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 group";
    $active   = "bg-white bg-opacity-15 text-white shadow-sm";
    $inactive = "text-teal-100 hover:bg-white hover:bg-opacity-10 hover:text-white";
    $cls = $base . ' ' . ($isActive ? $active : $inactive);
    $indicator = $isActive ? '<span class="ml-auto w-1.5 h-1.5 rounded-full bg-teal-300"></span>' : '';
    echo "<a href=\"$href\" class=\"$cls\">$icon <span>$label</span>$indicator</a>";
}
?>
<aside class="w-64 flex-shrink-0 min-h-screen flex flex-col relative"
       style="background: linear-gradient(160deg, #042f2e 0%, #0d5c55 50%, #0f766e 100%);">

  <!-- Decorative circle -->
  <div class="absolute top-0 right-0 w-40 h-40 rounded-full opacity-5"
       style="background: radial-gradient(circle, #14b8a6, transparent); transform: translate(30%, -30%);"></div>
  <div class="absolute bottom-20 left-0 w-32 h-32 rounded-full opacity-5"
       style="background: radial-gradient(circle, #06b6d4, transparent); transform: translate(-30%, 0);"></div>

  <!-- Brand -->
  <div class="px-5 pt-6 pb-5">
    <div class="flex items-center gap-3">
      <div class="w-11 h-11 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-lg"
           style="background: linear-gradient(135deg, #14b8a6, #06b6d4);">
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
        </svg>
      </div>
      <div>
        <p class="text-white font-bold text-sm leading-tight">Admin Panel</p>
        <p class="text-teal-300 text-xs font-medium">Pengaduan Sarana</p>
      </div>
    </div>
  </div>

  <!-- Divider -->
  <div class="mx-5 h-px bg-white opacity-10 mb-4"></div>

  <!-- User Card -->
  <div class="mx-4 mb-5 p-3 rounded-2xl" style="background: rgba(255,255,255,0.07);">
    <div class="flex items-center gap-3">
      <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white font-bold text-base flex-shrink-0 shadow"
           style="background: linear-gradient(135deg, #14b8a6, #0891b2);">
        <?= strtoupper(substr($_SESSION['admin'], 0, 1)) ?>
      </div>
      <div class="min-w-0">
        <p class="text-white text-sm font-semibold truncate"><?= htmlspecialchars($_SESSION['admin']) ?></p>
        <div class="flex items-center gap-1 mt-0.5">
          <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
          <p class="text-teal-300 text-xs">Online</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Nav Label -->
  <p class="px-5 text-teal-400 text-xs font-semibold uppercase tracking-widest mb-2">Menu</p>

  <!-- Nav -->
  <nav class="flex-1 px-3 space-y-0.5">
    <?php
    $menus = [
      'dashboard.php' => [
        'label' => 'Dashboard',
        'icon'  => '<svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>',
      ],
      'data_aspirasi.php' => [
        'label' => 'Data Aspirasi',
        'icon'  => '<svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>',
      ],
      'kelola_kategori.php' => [
        'label' => 'Kelola Kategori',
        'icon'  => '<svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>',
      ],
      'kelola_admin.php' => [
        'label' => 'Kelola Admin',
        'icon'  => '<svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>',
      ],
    ];
    foreach($menus as $file => $m) {
      navLink($file, $m['label'], $m['icon'], $currentPage);
    }
    ?>

    <!-- Divider -->
    <div class="py-2"><div class="h-px bg-white opacity-10"></div></div>
    <p class="px-2 text-teal-400 text-xs font-semibold uppercase tracking-widest pb-1">Lainnya</p>

    <?php
    navLink('about.php', 'About',
      '<svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
      $currentPage
    );
    ?>
  </nav>

  <!-- Bottom -->
  <div class="p-3 mt-4">
    <div class="h-px bg-white opacity-10 mb-3"></div>
    <a href="../proses/logout.php"
       class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium text-red-300 hover:bg-red-500 hover:bg-opacity-20 hover:text-red-200 transition-all duration-200">
      <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
      </svg>
      <span>Logout</span>
    </a>
  </div>

</aside>
