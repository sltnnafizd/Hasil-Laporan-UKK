<!-- Header -->
<header class="bg-blue-700 text-white p-4 flex items-center justify-between">
  <!-- Tombol Hamburger -->
  <button id="menu-btn" class="focus:outline-none">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none"
         viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M4 6h16M4 12h16M4 18h16" />
    </svg>
  </button>
  <h1 class="text-xl font-bold">Aplikasi Pengaduan</h1>
</header>

<!-- Sidebar -->
<aside id="sidebar" class="fixed top-0 left-0 w-64 bg-blue-700 text-white h-full p-6 transform -translate-x-full transition-transform duration-300 ease-in-out z-40">
  <h2 class="text-2xl font-bold mb-6">Menu</h2>
  <nav class="space-y-2">
    <a href="siswa/histori.php" class="block px-3 py-2 rounded hover:bg-blue-600">Histori</a>
    <a href="login.php" class="block px-3 py-2 rounded hover:bg-blue-600">Admin</a>
    <a href="about.php" class="block px-3 py-2 rounded hover:bg-blue-600">About</a>
  </nav>
</aside>

<!-- Overlay -->
<div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-30"></div>

<script>
  const menuBtn = document.getElementById('menu-btn');
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');

  menuBtn.addEventListener('click', () => {
    sidebar.classList.toggle('-translate-x-full');
    overlay.classList.toggle('hidden');
  });

  overlay.addEventListener('click', () => {
    sidebar.classList.add('-translate-x-full');
    overlay.classList.add('hidden');
  });
</script>
