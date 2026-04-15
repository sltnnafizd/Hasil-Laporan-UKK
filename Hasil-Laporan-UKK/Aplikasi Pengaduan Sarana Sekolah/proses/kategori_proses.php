<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: ../login.php");
    exit;
}
include "../config/koneksi.php";

$aksi = $_POST['aksi'] ?? $_GET['aksi'] ?? '';

if($aksi === 'tambah'){
    $nama = mysqli_real_escape_string($conn, trim($_POST['ket_kategori']));

    if(empty($nama)){
        header("Location: ../admin/kelola_kategori.php?pesan=Nama+kategori+tidak+boleh+kosong");
        exit;
    }

    $cek = mysqli_query($conn, "SELECT id_kategori FROM kategori WHERE ket_kategori='$nama'");
    if(mysqli_num_rows($cek) > 0){
        header("Location: ../admin/kelola_kategori.php?pesan=Kategori+sudah+ada");
        exit;
    }

    mysqli_query($conn, "INSERT INTO kategori (ket_kategori) VALUES ('$nama')");
    header("Location: ../admin/kelola_kategori.php?pesan=berhasil");
    exit;
}

if($aksi === 'edit'){
    $id   = (int)$_POST['id'];
    $nama = mysqli_real_escape_string($conn, trim($_POST['ket_kategori']));

    if(empty($nama)){
        header("Location: ../admin/kelola_kategori.php?pesan=Nama+kategori+tidak+boleh+kosong");
        exit;
    }

    $cek = mysqli_query($conn, "SELECT id_kategori FROM kategori WHERE ket_kategori='$nama' AND id_kategori != $id");
    if(mysqli_num_rows($cek) > 0){
        header("Location: ../admin/kelola_kategori.php?pesan=Kategori+sudah+ada");
        exit;
    }

    mysqli_query($conn, "UPDATE kategori SET ket_kategori='$nama' WHERE id_kategori=$id");
    header("Location: ../admin/kelola_kategori.php?pesan=berhasil");
    exit;
}

if($aksi === 'hapus'){
    $id = (int)$_GET['id'];

    // Cek apakah kategori dipakai di aspirasi
    $cek = mysqli_query($conn, "SELECT id_pelaporan FROM input_aspirasi WHERE id_kategori=$id LIMIT 1");
    if(mysqli_num_rows($cek) > 0){
        header("Location: ../admin/kelola_kategori.php?pesan=Kategori+tidak+dapat+dihapus+karena+masih+digunakan");
        exit;
    }

    mysqli_query($conn, "DELETE FROM kategori WHERE id_kategori=$id");
    header("Location: ../admin/kelola_kategori.php?pesan=berhasil");
    exit;
}

if($aksi === 'reset'){
    $default = [
        'Kursi / Meja',
        'Papan Tulis',
        'Proyektor / LCD',
        'Komputer / Laptop',
        'Kipas Angin / AC',
        'Lampu / Listrik',
        'Pintu / Jendela',
        'Kran / Pipa Air',
        'Alat Olahraga',
        'Lainnya',
    ];

    // Hapus kategori yang tidak sedang dipakai
    $dipakai = [];
    $res = mysqli_query($conn, "SELECT DISTINCT id_kategori FROM input_aspirasi");
    while($r = mysqli_fetch_row($res)) $dipakai[] = $r[0];

    if(empty($dipakai)){
        mysqli_query($conn, "DELETE FROM kategori");
    } else {
        $ids = implode(',', $dipakai);
        mysqli_query($conn, "DELETE FROM kategori WHERE id_kategori NOT IN ($ids)");
    }

    // Tambahkan kategori default yang belum ada
    foreach($default as $nama){
        $nama = mysqli_real_escape_string($conn, $nama);
        $cek  = mysqli_query($conn, "SELECT id_kategori FROM kategori WHERE ket_kategori='$nama'");
        if(mysqli_num_rows($cek) === 0){
            mysqli_query($conn, "INSERT INTO kategori (ket_kategori) VALUES ('$nama')");
        }
    }

    header("Location: ../admin/kelola_kategori.php?pesan=berhasil");
    exit;
}

header("Location: ../admin/kelola_kategori.php");
exit;
