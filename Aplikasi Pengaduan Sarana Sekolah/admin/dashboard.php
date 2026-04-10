<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: ../login.php");
    exit;
}
include "../config/koneksi.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div class="flex">

  <!-- Sidebar -->
  <div class="w-64 bg-blue-700 text-white min-h-screen p-4">
    <h2 class="text-xl mb-4">Admin</h2>
    <p class="mb-4">Selamat datang, <b><?= $_SESSION['admin']; ?></b></p>
    <a href="../index.php" class="block py-1 hover:bg-blue-600 rounded px-2">Home</a>
    <a href="data_aspirasi.php" class="block py-1 hover:bg-blue-600 rounded px-2">Data Aspirasi</a>
    <a href="../proses/logout.php" class="block py-1 hover:bg-blue-600 rounded px-2">Logout</a>
  </div>

  <!-- Content -->
  <div class="p-6 w-full">
    <h1 class="text-2xl font-bold mb-4">Dashboard Admin</h1>

    <?php
    $total = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM input_aspirasi"));
    ?>

    <div class="bg-white p-6 shadow rounded">
      <p class="text-lg">Total Pengaduan: <b><?= $total ?></b></p>
    </div>
  </div>
</div>
</body>
</html>
