<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: ../login.php");
    exit;
}
include "../config/koneksi.php";

$aksi = $_POST['aksi'] ?? $_GET['aksi'] ?? '';

if($aksi === 'tambah'){
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = mysqli_real_escape_string($conn, trim($_POST['password']));

    if(empty($username) || empty($password)){
        header("Location: ../admin/kelola_admin.php?pesan=Username+dan+password+tidak+boleh+kosong");
        exit;
    }

    // Cek duplikat
    $cek = mysqli_query($conn, "SELECT id_admin FROM admin WHERE username='$username'");
    if(mysqli_num_rows($cek) > 0){
        header("Location: ../admin/kelola_admin.php?pesan=Username+sudah+digunakan");
        exit;
    }

    mysqli_query($conn, "INSERT INTO admin (username, password) VALUES ('$username', '$password')");
    header("Location: ../admin/kelola_admin.php?pesan=berhasil");
    exit;
}

if($aksi === 'edit'){
    $id       = (int)$_POST['id'];
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = trim($_POST['password'] ?? '');

    if(empty($username)){
        header("Location: ../admin/kelola_admin.php?pesan=Username+tidak+boleh+kosong");
        exit;
    }

    // Cek duplikat (selain diri sendiri)
    $cek = mysqli_query($conn, "SELECT id_admin FROM admin WHERE username='$username' AND id_admin != $id");
    if(mysqli_num_rows($cek) > 0){
        header("Location: ../admin/kelola_admin.php?pesan=Username+sudah+digunakan");
        exit;
    }

    if(!empty($password)){
        $password = mysqli_real_escape_string($conn, $password);
        mysqli_query($conn, "UPDATE admin SET username='$username', password='$password' WHERE id_admin=$id");
    } else {
        mysqli_query($conn, "UPDATE admin SET username='$username' WHERE id_admin=$id");
    }

    // Update session jika admin mengedit akunnya sendiri
    $cekSesi = mysqli_query($conn, "SELECT username FROM admin WHERE id_admin=$id");
    $row = mysqli_fetch_assoc($cekSesi);
    if($row && $_SESSION['admin'] !== $username){
        // username lama == session saat ini → update session
        $oldUsername = mysqli_real_escape_string($conn, $_SESSION['admin']);
        $cekOld = mysqli_query($conn, "SELECT id_admin FROM admin WHERE username='$oldUsername' AND id_admin=$id");
        if(mysqli_num_rows($cekOld) > 0){
            $_SESSION['admin'] = $username;
        }
    }

    header("Location: ../admin/kelola_admin.php?pesan=berhasil");
    exit;
}

if($aksi === 'hapus'){
    $id = (int)$_GET['id'];

    // Cari username yang akan dihapus
    $cek = mysqli_query($conn, "SELECT username FROM admin WHERE id_admin=$id");
    $row = mysqli_fetch_assoc($cek);

    // Jangan hapus akun yang sedang login
    if($row && $row['username'] === $_SESSION['admin']){
        header("Location: ../admin/kelola_admin.php?pesan=Tidak+dapat+menghapus+akun+yang+sedang+aktif");
        exit;
    }

    // Jangan hapus jika hanya tersisa 1 admin
    $total = mysqli_num_rows(mysqli_query($conn, "SELECT id_admin FROM admin"));
    if($total <= 1){
        header("Location: ../admin/kelola_admin.php?pesan=Minimal+harus+ada+1+admin");
        exit;
    }

    mysqli_query($conn, "DELETE FROM admin WHERE id_admin=$id");
    header("Location: ../admin/kelola_admin.php?pesan=berhasil");
    exit;
}

header("Location: ../admin/kelola_admin.php");
exit;
