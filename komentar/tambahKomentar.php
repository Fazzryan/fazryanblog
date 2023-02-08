<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['username'])) {
    echo "
    <script>
        alert('Anda harus login terlebih dahulu!');
        window.location='../otentikasi/login.php';
    </script>
    ";
} else {
    $username = $_SESSION["username"];
    // id user komentar adalah id user yang sedang login
    $id = $_SESSION["id"];
    $id_postingan = $_POST["id_postingan"];
    $pesan = $_POST["pesan"];
    date_default_timezone_set('Asia/Jakarta');
    $tgl_pesan = date("Y-m-d H:i:s");

    $insert = mysqli_query($koneksi, "INSERT INTO komentar_dindafazryan (id_komentar, id_user_komentar, id_postingan, pesan, tgl_pesan)
        VALUES ('','$id', '$id_postingan', '$pesan', '$tgl_pesan')
    ");

    if ($insert) {
        echo "
        <script>
            alert('Komentar berhasil ditambahkan!');
            window.location='../index.php';
        </script>
        ";
    } else {
        echo "
            <script>
                alert('Gagal menambah komentar!');
            </script>
        ";
    }
    // echo $id_postingan . " " . $id . " " . $pesan . " " . $tgl_pesan;
}
