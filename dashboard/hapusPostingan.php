<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['username'])) {
    header('location:../otentikasi/login.php');
}

$slug = $_GET["slug"];

$postingan = mysqli_query($koneksi, "SELECT * FROM postingan_dindafazryan where slug = '$slug'");
$data = mysqli_fetch_array($postingan);
$hapus = mysqli_query($koneksi, "DELETE FROM postingan_dindafazryan where slug = '$slug'");
if ($hapus) {
    unlink("../fileUploadGambar/$data[gambar]");
    header("location: index.php");
} else {
    echo "Gagal menghapus data!";
    header("location: index.php");
}
