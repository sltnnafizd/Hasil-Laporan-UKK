<?php include "config/koneksi.php"; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .form-group { position: relative; margin-bottom: 1.5rem; }
    .form-group input {
      width: 100%; padding: 12px; border: 1px solid #d1d5db;
      border-radius: 6px; font-size: 14px; background: none;
    }
    .form-group label {
      position: absolute; left: 12px; top: 12px; color: #6b7280;
      font-size: 14px; pointer-events: none; transition: 0.2s ease all;
      background: #fff; padding: 0 4px;
    }
    .form-group input:focus + label,
    .form-group input:not(:placeholder-shown) + label {
      top: -8px; left: 8px; font-size: 12px; color: #2563eb;
    }
    .helper { font-size: 12px; color: #9ca3af; margin-top: 4px; }
  </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

  <div class="bg-white p-8 rounded-2xl shadow-2xl w-[400px]">
    <!-- Icon -->
    <div class="flex justify-center mb-4">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-600" fill="none"
           viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 11c0-1.105-.895-2-2-2s-2 .895-2 2 .895 2 2 2 2-.895 2-2zm0 0v6m0-6V5" />
      </svg>
    </div>

    <!-- Judul -->
    <h2 class="text-2xl font-bold text-center mb-1 text-blue-700">Login Admin</h2>
    <p class="text-center text-gray-600 mb-6">Sistem Pengaduan Kerusakan Fasilitas</p>

    <!-- Form -->
    <form action="proses/login_admin.php" method="POST">
      <div class="form-group">
        <input id="username" name="username" type="text" placeholder=" " required>
        <label for="username">Username</label>
        <p class="helper">Masukkan username</p>
      </div>

      <div class="form-group">
        <input id="password" name="password" type="password" placeholder=" " required>
        <label for="password">Password</label>
        <p class="helper">Masukkan password</p>
      </div>

      <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded font-semibold">
        Masuk
      </button>
    </form>

    <!-- Link bawah -->
    <div class="mt-6 text-center">
      <p class="text-gray-600">Bukan admin? <a href="index.php" class="text-blue-600 hover:underline">Buat pengaduan</a></p>
    </div>
  </div>

</body>
</html>
