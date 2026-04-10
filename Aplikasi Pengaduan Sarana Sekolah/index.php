<?php include "config/koneksi.php"; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Form Pengaduan</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="assets/style.css"> <!-- stylesheet tambahan -->
</head>
<body class="bg-gray-100 min-h-screen">

  <!-- Header -->
  <header class="bg-blue-700 text-white p-4 flex items-center justify-between">
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

  <!-- Konten Utama -->
  <main class="p-8 flex justify-center">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-[450px]">
      <!-- Logo -->
      <div class="flex justify-center mb-4">
        <img src="assets/img/neskar_logo.png" alt="Logo Sekolah" class="h-20 w-20 rounded-full shadow">
      </div>

      <h2 class="text-3xl font-bold text-center mb-2 text-blue-700">Form Pengaduan</h2>
      <p class="text-center text-gray-600 mb-6">Laporkan kerusakan fasilitas sekolah</p>

      <form action="proses/simpan_aspirasi.php" method="POST" class="space-y-5">
        <!-- NIS -->
        <div>
          <label for="nis" class="block text-gray-800 font-semibold mb-2">NIS</label>
          <input id="nis" name="nis" placeholder="Nomor Induk Siswa"
                 class="w-full border p-2 rounded focus:ring focus:ring-blue-300">
        </div>

        <!-- Kategori -->
        <div>
          <label for="id_kategori" class="block text-gray-800 font-semibold mb-2">Kategori</label>
          <select id="id_kategori" name="id_kategori"
                  class="w-full border p-2 rounded focus:ring focus:ring-blue-300">
            <option value="">Pilih kategori</option>
            <?php
            $data = mysqli_query($conn,"SELECT * FROM kategori");
            while($d=mysqli_fetch_array($data)){
            ?>
            <option value="<?= $d['id_kategori'] ?>"><?= $d['ket_kategori'] ?></option>
            <?php } ?>
          </select>
        </div>

        <!-- Lokasi -->
        <div>
          <label for="lokasi" class="block text-gray-800 font-semibold mb-2">Lokasi Kerusakan</label>
          <input id="lokasi" name="lokasi" placeholder="Contoh: Ruang Kelas X-1"
                 class="w-full border p-2 rounded focus:ring focus:ring-blue-300">
        </div>

        <!-- Keterangan -->
        <div>
          <label for="ket" class="block text-gray-800 font-semibold mb-2">Keterangan</label>
          <textarea id="ket" name="ket" placeholder="Jelaskan kerusakan secara detail..."
                    class="w-full border p-2 rounded focus:ring focus:ring-blue-300"></textarea>
        </div>

        <!-- Tombol -->
        <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded font-semibold">
          Kirim Pengaduan
        </button>
      </form>

      <!-- Extra Links -->
      <div class="mt-6 text-center space-y-2">
        <a href="siswa/histori.php" class="text-blue-600 hover:underline font-semibold">Cek Status Pengaduan</a>
        <p class="text-gray-600">Admin? <a href="login.php" class="text-blue-600 hover:underline">Login di sini</a></p>
      </div>
    </div>
  </main>

  <!-- Script toggle sidebar -->
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
</body>
</html>
