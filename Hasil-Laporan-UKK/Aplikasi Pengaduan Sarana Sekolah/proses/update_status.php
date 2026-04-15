<?php
session_start();
if(!isset($_SESSION['admin'])){ header("Location: ../login.php"); exit; }
include "../config/koneksi.php";

$id       = isset($_POST['id_pelaporan']) ? (int)$_POST['id_pelaporan'] : 0;
$status   = mysqli_real_escape_string($conn, $_POST['status']   ?? '');
$feedback = mysqli_real_escape_string($conn, trim($_POST['feedback'] ?? ''));
$admin    = mysqli_real_escape_string($conn, $_SESSION['admin']);

if(!$id || !$status){ header("Location: ../admin/data_aspirasi.php"); exit; }

// Ambil status lama
$q = mysqli_query($conn,"SELECT COALESCE(a.status,'Menunggu') as status, ia.id_kategori
                          FROM input_aspirasi ia
                          LEFT JOIN aspirasi a ON ia.id_pelaporan=a.id_pelaporan
                          WHERE ia.id_pelaporan=$id");
$row = mysqli_fetch_assoc($q);
$statusLama  = mysqli_real_escape_string($conn, $row['status']);
$id_kategori = (int)$row['id_kategori'];

// Cek sudah ada record aspirasi atau belum
$cek = mysqli_query($conn,"SELECT id FROM aspirasi WHERE id_pelaporan=$id");
if(mysqli_num_rows($cek) > 0){
    mysqli_query($conn,"UPDATE aspirasi SET status='$status', feedback='$feedback', updated_at=NOW() WHERE id_pelaporan=$id");
} else {
    mysqli_query($conn,"INSERT INTO aspirasi (id_pelaporan, id_kategori, status, feedback) VALUES ($id, $id_kategori, '$status', '$feedback')");
}

// Catat histori
mysqli_query($conn,"INSERT INTO histori (id_pelaporan, status_lama, status_baru, feedback, diubah_oleh) VALUES ($id, '$statusLama', '$status', '$feedback', '$admin')");

header("Location: ../admin/feedback.php?id=$id&saved=1");
exit;
