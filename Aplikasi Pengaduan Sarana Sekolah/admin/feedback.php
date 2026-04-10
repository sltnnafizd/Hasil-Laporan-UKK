<?php
include "../config/koneksi.php";
$id = $_GET['id'];

$data = mysqli_query($conn,"SELECT * FROM input_aspirasi WHERE id_pelaporan='$id'");
$d = mysqli_fetch_array($data);
?>

<form method="POST">

<p><?= $d['ket'] ?></p>

<select name="status">
<option>Menunggu</option>
<option>Proses</option>
<option>Selesai</option>
</select>

<textarea name="feedback"></textarea>

<button name="simpan">Simpan</button>

</form>

<?php
if(isset($_POST['simpan'])){
mysqli_query($conn,"INSERT INTO aspirasi
(id_pelaporan,status,id_kategori,feedback)
VALUES
('$id','$_POST[status]','".$d['id_kategori']."','$_POST[feedback]')");

header("Location: data_aspirasi.php");
}
?>