<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['username'])) {
    header('location:../otentikasi/login.php');
}

$kategori = $_POST["kategori"];
$userId = $_SESSION["id"];
$judul = $_POST["judul"];
$slug = $_POST["slug"];
$body   = $_POST["body"];

$target_dir =  "../fileUploadGambar/";
$target_file = $target_dir . basename($_FILES["gambar"]["name"]);
$gambar = basename($_FILES["gambar"]["name"]);
$ukuran_file = $_FILES["gambar"]["size"];
$jenis_file = $_FILES["gambar"]["type"];
$upload_berhasil = 1;
$tipe_file = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));


// var_dump($gambar);
// die;
// Cek jika file sudah ada
if (file_exists($target_file)) {
    echo "
        <script>
            alert('File sudah ada, ganti nama gambar!')
            window.location='tambahPostingan.php'
        </script>
    ";
    $upload_berhasil = 0;
}
// Cek Ukuran File, ukuran dalam byte
if ($ukuran_file > 5000000) {
    echo "
        <script>
            alert('Ukuran file terlalu besar!')
            window.location='tambahPostingan.php'
        </script>
    ";
    $upload_berhasil = 0;
}
// Mengizinkan file dengan format tertentu
if ($tipe_file != "png" && $tipe_file != "jpeg" && $tipe_file != "jpg") {
    echo "
        <script>
            alert('File tidak di izinkan!')
            window.location='tambahPostingan.php'
        </script>
    ";
    $upload_berhasil = 0;
}
// Cek apakah $upload_berhasil nilainya 0 dan menampilkan pesan kesalahan
if ($upload_berhasil == 0) {
    echo "
        <script>
            alert('File tidak bisa diupload!')
            window.location='tambahPostingan.php'
        </script>
    ";
    // Jika $upload_berhasil = 1 maka coba upload file
} else {
    if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
        $simpan = mysqli_query($koneksi, "INSERT INTO postingan_dindafazryan 
        (id_postingan, id_kategori, id_user, judul, slug, body, gambar)
         VALUES 
        ('','$kategori','$userId','$judul', '$slug', '$body', '$gambar')");
        if ($simpan) {
            header("location:index.php");
        } else {
            echo "Gagal Simpan";
        }
    } else {
        echo "Upload file gagal";
    }
}
