<?php
session_start();
if(!isset($_SESSION['admin'])){ header("Location: ../login.php"); exit; }
include "../config/koneksi.php";

$admins = mysqli_query($conn, "SELECT * FROM admin ORDER BY id_admin ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kelola Admin — Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>body { font-family: 'Inter', sans-serif; background: #f1f5f9; }</style>
</head>
<body class="flex min-h-screen">

  <?php include '../layout/sidebar.php'; ?>

  <main class="flex-1 overflow-auto">

    <!-- Topbar -->
    <div class="bg-white border-b border-gray-200 px-8 py-4 sticky top-0 z-10">
      <h1 class="text-xl font-bold text-gray-800">Kelola Admin</h1>
      <p class="text-gray-500 text-sm">Tambah, edit, atau hapus akun administrator</p>
    </div>

    <div class="p-8 max-w-3xl">

      <!-- Alert -->
      <?php if(isset($_GET['pesan'])):
        $ok = $_GET['pesan'] === 'berhasil';
      ?>
      <div class="mb-6 flex items-center gap-3 px-5 py-4 rounded-2xl text-sm
                  <?= $ok ? 'bg-green-50 border border-green-200 text-green-700' : 'bg-red-50 border border-red-200 text-red-700' ?>">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <?php if($ok): ?>
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
          <?php else: ?>
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
          <?php endif; ?>
        </svg>
        <?= $ok ? 'Operasi berhasil.' : htmlspecialchars($_GET['pesan']) ?>
      </div>
      <?php endif; ?>

      <!-- Form Tambah -->
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <h2 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
          <span class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
            </svg>
          </span>
          Tambah Admin Baru
        </h2>
        <form action="../proses/admin_proses.php" method="POST" class="flex gap-3 flex-wrap">
          <input type="hidden" name="aksi" value="tambah">
          <input type="text" name="username" placeholder="Username" required
                 class="border-2 border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition w-48">
          <input type="password" name="password" placeholder="Password" required
                 class="border-2 border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition w-48">
          <button class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah
          </button>
        </form>
      </div>

      <!-- Tabel -->
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
          <h2 class="font-bold text-gray-800">Daftar Administrator</h2>
        </div>
        <table class="w-full text-sm">
          <thead>
            <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wide">
              <th class="px-6 py-3 text-left w-12">No</th>
              <th class="px-6 py-3 text-left">Username</th>
              <th class="px-6 py-3 text-left">Status</th>
              <th class="px-6 py-3 text-left w-36">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-50">
            <?php $no=1; while($a = mysqli_fetch_assoc($admins)):
              $isMe = $a['username'] === $_SESSION['admin'];
            ?>
            <tr class="hover:bg-blue-50 transition-colors">
              <td class="px-6 py-4 text-gray-400 text-xs"><?= $no++ ?></td>
              <td class="px-6 py-4">
                <div class="flex items-center gap-3">
                  <div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                    <?= strtoupper(substr($a['username'], 0, 1)) ?>
                  </div>
                  <span class="font-semibold text-gray-800"><?= htmlspecialchars($a['username']) ?></span>
                </div>
              </td>
              <td class="px-6 py-4">
                <?php if($isMe): ?>
                <span class="inline-flex items-center gap-1.5 bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full">
                  <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                  Aktif (Anda)
                </span>
                <?php else: ?>
                <span class="inline-flex items-center gap-1.5 bg-gray-100 text-gray-500 text-xs font-medium px-3 py-1 rounded-full">
                  <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                  Admin
                </span>
                <?php endif; ?>
              </td>
              <td class="px-6 py-4">
                <div class="flex gap-2">
                  <button onclick="bukaModal(<?= $a['id_admin'] ?>, '<?= htmlspecialchars($a['username'], ENT_QUOTES) ?>')"
                          class="inline-flex items-center gap-1 bg-yellow-50 hover:bg-yellow-100 text-yellow-700 text-xs font-medium px-3 py-1.5 rounded-lg transition">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit
                  </button>
                  <?php if(!$isMe): ?>
                  <a href="../proses/admin_proses.php?aksi=hapus&id=<?= $a['id_admin'] ?>"
                     onclick="return confirm('Hapus admin ini?')"
                     class="inline-flex items-center gap-1 bg-red-50 hover:bg-red-100 text-red-600 text-xs font-medium px-3 py-1.5 rounded-lg transition">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Hapus
                  </a>
                  <?php endif; ?>
                </div>
              </td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>

    </div>
  </main>

  <!-- Modal Edit -->
  <div id="modal-edit" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 flex">
    <div class="bg-white rounded-2xl shadow-2xl p-6 w-96 mx-4">
      <div class="flex items-center justify-between mb-5">
        <h2 class="text-lg font-bold text-gray-800">Edit Admin</h2>
        <button onclick="tutupModal()" class="text-gray-400 hover:text-gray-600 transition">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>
      <form action="../proses/admin_proses.php" method="POST">
        <input type="hidden" name="aksi" value="edit">
        <input type="hidden" name="id" id="edit-id">
        <div class="mb-4">
          <label class="block text-sm font-semibold text-gray-700 mb-2">Username</label>
          <input type="text" name="username" id="edit-username" required
                 class="w-full border-2 border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition">
        </div>
        <div class="mb-5">
          <label class="block text-sm font-semibold text-gray-700 mb-2">
            Password Baru
            <span class="text-gray-400 font-normal text-xs ml-1">(kosongkan jika tidak diubah)</span>
          </label>
          <input type="password" name="password" placeholder="Password baru..."
                 class="w-full border-2 border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition">
        </div>
        <div class="flex justify-end gap-2">
          <button type="button" onclick="tutupModal()"
                  class="px-4 py-2 rounded-xl border border-gray-200 text-sm text-gray-600 hover:bg-gray-50 transition">Batal</button>
          <button class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold transition">Simpan</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    function bukaModal(id, username) {
      document.getElementById('edit-id').value = id;
      document.getElementById('edit-username').value = username;
      document.getElementById('modal-edit').classList.remove('hidden');
    }
    function tutupModal() {
      document.getElementById('modal-edit').classList.add('hidden');
    }
  </script>
</body>
</html>
