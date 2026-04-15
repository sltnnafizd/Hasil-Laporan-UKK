<?php
include "../config/koneksi.php";

$nis         = $_POST['nis'] ?? '';
$id_kategori = $_POST['id_kategori'] ?? '';
$lokasi      = $_POST['lokasi'] ?? '';
$ket         = $_POST['ket'] ?? '';

if($nis == '' || $id_kategori == '' || $lokasi == '' || $ket == ''){
    header("Location: ../index.php?error=1");
    exit;
}

$stmt = $conn->prepare("INSERT INTO input_aspirasi (nis, id_kategori, lokasi, ket) VALUES (?, ?, ?, ?)");
$stmt->bind_param("siss", $nis, $id_kategori, $lokasi, $ket);

if($stmt->execute()){
    header("Location: ../index.php?success=1");
} else {
    header("Location: ../index.php?error=1");
}

$stmt->close();
$conn->close();
?>
