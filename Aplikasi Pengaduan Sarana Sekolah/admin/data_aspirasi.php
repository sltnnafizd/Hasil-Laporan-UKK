<?php
session_start();
include "../config/koneksi.php";

$data = mysqli_query($conn,"
SELECT input_aspirasi.*, kategori.ket_kategori, aspirasi.status
FROM input_aspirasi
LEFT JOIN kategori ON input_aspirasi.id_kategori = kategori.id_kategori
LEFT JOIN aspirasi ON input_aspirasi.id_pelaporan = aspirasi.id_pelaporan
");
?>

<script src="https://cdn.tailwindcss.com"></script>

<h2 class="text-xl font-bold p-4">Data Aspirasi</h2>

<table class="w-full border">

<tr class="bg-gray-200">
<th>NIS</th>
<th>Kategori</th>
<th>Lokasi</th>
<th>Status</th>
<th>Aksi</th>
</tr>

<?php while($d=mysqli_fetch_array($data)){ ?>

<tr class="text-center">
<td><?= $d['nis'] ?></td>
<td><?= $d['ket_kategori'] ?></td>
<td><?= $d['lokasi'] ?></td>
<td><?= $d['status'] ?? 'Menunggu' ?></td>

<td>
<a href="feedback.php?id=<?= $d['id_pelaporan'] ?>" class="text-blue-500">Proses</a>
</td>

</tr>

<?php } ?>

</table>