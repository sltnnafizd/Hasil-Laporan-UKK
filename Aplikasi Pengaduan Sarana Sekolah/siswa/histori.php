<?php
include "../config/koneksi.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Histori Pengaduan</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
  <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-5xl">
    <h2 class="text-3xl font-bold mb-6 text-center text-blue-700">Histori Pengaduan</h2>
    <?php
    $query = "SELECT ia.id_pelaporan, ia.nis, ia.lokasi, ia.ket, k.ket_kategori, 
                     a.status, a.feedback
              FROM input_aspirasi ia
              JOIN kategori k ON ia.id_kategori = k.id_kategori
              LEFT JOIN aspirasi a ON ia.id_pelaporan = a.id_pelaporan
              ORDER BY ia.id_pelaporan DESC";
    $result = mysqli_query($conn, $query);
    ?>
    <table class="table-auto w-full border-collapse border border-gray-300">
      <thead>
        <tr class="bg-blue-600 text-white">
          <th class="border px-4 py-2">ID</th>
          <th class="border px-4 py-2">NIS</th>
          <th class="border px-4 py-2">Kategori</th>
          <th class="border px-4 py-2">Lokasi</th>
          <th class="border px-4 py-2">Keterangan</th>
          <th class="border px-4 py-2">Status</th>
          <th class="border px-4 py-2">Feedback</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr class="hover:bg-gray-100">
          <td class="border px-4 py-2"><?= $row['id_pelaporan']; ?></td>
          <td class="border px-4 py-2"><?= $row['nis']; ?></td>
          <td class="border px-4 py-2"><?= $row['ket_kategori']; ?></td>
          <td class="border px-4 py-2"><?= $row['lokasi']; ?></td>
          <td class="border px-4 py-2"><?= $row['ket']; ?></td>
          <td class="border px-4 py-2"><?= $row['status'] ?? 'Menunggu'; ?></td>
          <td class="border px-4 py-2"><?= $row['feedback'] ?? '-'; ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
    <div class="text-center mt-6">
      <a href="../index.php" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Kembali ke Form</a>
    </div>
  </div>
</body>
</html>
