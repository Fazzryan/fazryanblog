<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['username'])) {
    header('location:../otentikasi/login.php');
}

$idPostingan = $_POST["id_postingan"];
$kategori = $_POST["kategori"];
$userId = $_SESSION["id"];
$judul = $_POST["judul"];
$slug = $_POST["slug"];
$body   = $_POST["body"];

$target_dir =  "../fileUploadGambar/";
$target_file = $target_dir . basename($_FILES["gambar"]["name"]);
$ukuran_file = $_FILES["gambar"]["size"];
$jenis_file = $_FILES["gambar"]["type"];
$upload_berhasil = 1;
$tipe_file = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

$newGambar =  basename($_FILES["gambar"]["name"]);
$oldGambar =  $_POST["oldGambar"];

if ($newGambar != '') {
    $updateGambar = basename($_FILES["gambar"]["name"]);
} else {
    $updateGambar = $oldGambar;
}


// Cek jika file sudah ada
if ($_FILES["gambar"]["name"] != '') {
    if (file_exists($target_file)) {
        echo "
            <script>
                alert('File sudah ada, ganti nama gambar!')
                window.location='index.php'
            </script>
        ";
        $upload_berhasil = 0;
    }
}
// Cek Ukuran File, ukuran dalam byte
if ($ukuran_file > 5000000) {
    echo "
        <script>
            alert('Ukuran file terlalu besar!')
            window.location='index.php'
        </script>
    ";
    $upload_berhasil = 0;
}
// Mengizinkan file dengan format tertentu
/* if ($tipe_file != "png" && $tipe_file != "jpeg" && $tipe_file != "jpg") {
    echo "
        <script>
            alert('File tidak di izinkan!')
            window.location='index.php'
        </script>
    ";
    $upload_berhasil = 0;
} */

// Cek apakah $upload_berhasil nilainya 0 dan menampilkan pesan kesalahan
if ($upload_berhasil == 0) {
    echo "
        <script>
            alert('File tidak bisa diupload!')
            window.location='index.php'
        </script>
    ";
    // Jika $upload_berhasil = 1 maka coba upload file
} else {

    $simpan = mysqli_query($koneksi, "UPDATE postingan_dindafazryan SET id_kategori='$kategori', id_user='$userId', judul='$judul', slug='$slug', body='$body', gambar='$updateGambar' WHERE id_postingan = '$idPostingan'");
    if ($simpan) {
        if ($_FILES["gambar"]["name"] != '') {
            move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file);
            unlink($target_dir . $oldGambar);
        }
        header("location:index.php");
    } else {
        echo "Gagal update!";
    }
}
