<?php include "config/koneksi.php"; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Admin — Pengaduan Sarana</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Inter', sans-serif; }
    .gradient-bg { background: linear-gradient(135deg, #042f2e 0%, #0f766e 60%, #14b8a6 100%); }
    .input-field {
      width: 100%; padding: 13px 16px 13px 44px;
      border: 2px solid #e5e7eb; border-radius: 12px;
      font-size: 14px; transition: all 0.2s; outline: none; background: #f9fafb;
    }
    .input-field:focus { border-color: #14b8a6; background: #fff; box-shadow: 0 0 0 4px rgba(20,184,166,0.12); }
    .btn-login {
      background: linear-gradient(135deg, #0f766e, #14b8a6);
      color: white; padding: 14px; border-radius: 12px;
      font-weight: 700; font-size: 15px; width: 100%;
      border: none; cursor: pointer; transition: all 0.25s;
      box-shadow: 0 4px 15px rgba(20,184,166,0.4);
    }
    .btn-login:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(20,184,166,0.5); }
    .btn-login:active { transform: translateY(0); }
    .floating-shape {
      position: absolute; border-radius: 50%;
      background: rgba(255,255,255,0.04);
      animation: float 6s ease-in-out infinite;
    }
    @keyframes float {
      0%, 100% { transform: translateY(0px); }
      50% { transform: translateY(-20px); }
    }
  </style>
</head>
<body class="min-h-screen gradient-bg flex items-center justify-center p-4 relative overflow-hidden">

  <!-- Decorative shapes -->
  <div class="floating-shape w-96 h-96 -top-20 -left-20" style="animation-delay:0s;"></div>
  <div class="floating-shape w-64 h-64 bottom-10 right-10" style="animation-delay:2s;"></div>
  <div class="floating-shape w-48 h-48 top-1/2 left-1/4" style="animation-delay:4s;"></div>

  <div class="w-full max-w-md relative z-10">

    <!-- Logo area -->
    <div class="text-center mb-8">
      <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl mb-4 shadow-2xl"
           style="background: linear-gradient(135deg, #14b8a6, #06b6d4);">
        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
        </svg>
      </div>
      <h1 class="text-white text-2xl font-bold">Pengaduan Sarana</h1>
      <p class="text-teal-300 text-sm mt-1">Sistem Pelaporan Fasilitas Sekolah</p>
    </div>

    <!-- Card -->
    <div class="bg-white rounded-3xl shadow-2xl p-8">
      <div class="mb-6">
        <h2 class="text-gray-900 text-2xl font-bold">Selamat datang 👋</h2>
        <p class="text-gray-500 text-sm mt-1">Masuk ke panel admin untuk mengelola pengaduan</p>
      </div>

      <?php if(isset($_GET['error'])): ?>
      <div class="mb-5 flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        Username atau password salah. Silakan coba lagi.
      </div>
      <?php endif; ?>

      <form action="proses/login.php" method="POST" class="space-y-5">

        <!-- Username -->
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">Username</label>
          <div class="relative">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
              </svg>
            </span>
            <input type="text" name="username" class="input-field" placeholder="Masukkan username" required autofocus>
          </div>
        </div>

        <!-- Password -->
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
          <div class="relative">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
              </svg>
            </span>
            <input type="password" name="password" id="password" class="input-field" placeholder="Masukkan password" required>
            <button type="button" onclick="togglePass()" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
              <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
              </svg>
            </button>
          </div>
        </div>

        <button type="submit" class="btn-login">
          <span class="flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
            </svg>
            Masuk ke Dashboard
          </span>
        </button>
      </form>

      <div class="mt-6 pt-5 border-t border-gray-100 text-center">
        <a href="index.php" class="inline-flex items-center gap-1 text-sm text-teal-600 hover:text-teal-700 font-medium transition">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
          </svg>
          Kembali ke Form Pengaduan
        </a>
      </div>
    </div>

    <p class="text-center text-blue-400 text-xs mt-6">© 2024 Sistem Pengaduan Sarana Sekolah</p>
  </div>

  <script>
    function togglePass() {
      const input = document.getElementById('password');
      input.type = input.type === 'password' ? 'text' : 'password';
    }
  </script>
</body>
</html>
