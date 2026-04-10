<?php include "../config/koneksi.php"; ?>

<form method="POST">
<input name="kategori">
<button name="simpan">Tambah</button>
</form>

<?php
if(isset($_POST['simpan'])){
mysqli_query($conn,"INSERT INTO kategori (ket_kategori) VALUES ('$_POST[kategori]')");
}
?>