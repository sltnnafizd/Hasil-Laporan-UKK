<?php
include "../config/koneksi.php";

$id = $_GET['id'];

mysqli_query($conn,"DELETE FROM input_aspirasi WHERE id_pelaporan='$id'");

header("Location: ../admin/data_aspirasi.php");
?>