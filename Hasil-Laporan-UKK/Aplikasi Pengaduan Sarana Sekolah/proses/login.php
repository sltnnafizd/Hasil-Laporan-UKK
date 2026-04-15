<?php
session_start();
include "../config/koneksi.php";

// AUTO BUAT ADMIN kalau kosong
$cek = mysqli_query($conn,"SELECT * FROM admin");
if(mysqli_num_rows($cek) == 0){
    mysqli_query($conn,"INSERT INTO admin (username,password) VALUES ('admin','123')");
}

$user = $_POST['username'] ?? '';
$pass = $_POST['password'] ?? '';

$q = mysqli_query($conn,"SELECT * FROM admin WHERE username='$user' AND password='$pass'");

if(mysqli_num_rows($q) > 0){
    $data = mysqli_fetch_assoc($q);
    $_SESSION['admin'] = $data['username'];
    header("Location: ../admin/dashboard.php");
    exit;
}else{
    header("Location: ../login.php?error=1");
    exit;
}
?>
