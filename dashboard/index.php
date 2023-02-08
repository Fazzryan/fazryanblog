<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['username'])) {
    header('location:../otentikasi/login.php');
}
$user = $_SESSION["username"];
$getIdUser = mysqli_query($koneksi, "SELECT * FROM user_dindafazryan WHERE username = '$user'");
$data = mysqli_fetch_assoc($getIdUser);
$idUser = $data["id"];

$kategori = mysqli_query($koneksi, "SELECT * FROM kategori_dindafazryan");

$jmlPostingan = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM postingan_dindafazryan 
LEFT JOIN kategori_dindafazryan
ON postingan_dindafazryan.id_kategori = kategori_dindafazryan.id
WHERE postingan_dindafazryan.id_user = '$_SESSION[id]'");
$jmlPost = mysqli_fetch_array($jmlPostingan);

$postingan = mysqli_query($koneksi, "SELECT *
FROM postingan_dindafazryan
LEFT JOIN kategori_dindafazryan
ON postingan_dindafazryan.id_kategori = kategori_dindafazryan.id
WHERE postingan_dindafazryan.id_user = '$_SESSION[id]'
");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap Css -->
    <link rel="stylesheet" href="../asset/css/bootstrap.css">
    <!-- My Css -->
    <link rel="stylesheet" href="../asset/css/style.css">
    <!-- Font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <title>Dasboard - Fazzblog</title>
</head>

<body style="margin-top: 90px;">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light py-3 fixed-top nav-bar">
        <div class="container">
            <a class="navbar-brand fw-bold m-btn pri-btn" href="../index.php">
                <img src="../asset/img/logo.png" alt="logo" width="35">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link fw-600 font-15 mx-0 mx-lg-2 " href="../index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-600 font-15 mx-0 mx-lg-2" href="../about.php">Tentang Saya</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link m-btn pri-btn dropdown-toggle px-2 fw-600" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Kategori
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <?php foreach ($kategori as $item) : ?>
                                <li><a class="dropdown-item" href="../postingan/postByKategori.php?id_kategori=<?= $item["id"] ?>"><?= $item["nama_kategori"] ?></a></li>
                            <?php endforeach ?>
                        </ul>
                    </li>
                </ul>
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <?php if (isset($_SESSION["username"])) : ?>
                        <li class="nav-item dropdown">
                            <a class="m-btn pri-btn py-2 px-3 fw-600 font-15 dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Halo, <?= $user ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item font-14" href="index.php"><i class="fa-solid fa-chart-line me-1"></i> Dashboard</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item font-14" href="../otentikasi/logout.php"><i class="fa-solid fa-arrow-right-from-bracket me-1"></i> Logout</a></li>
                            </ul>
                        </li>
                    <?php else : ?>
                        <li class="nav-item mx-lg-3">
                            <a class="m-btn pri-btn font-15" href="../otentikasi/login.php">
                                <i class="fa-solid fa-arrow-right-to-bracket me-1"></i>
                                Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="m-btn pri-btn fw-600 font-15 mt-2 mt-lg-0" href="../otentikasi/registrasi.php">
                                Registrasi Gratis
                            </a>
                        </li>
                    <?php endif ?>
                </ul>
            </div>
        </div>
    </nav>

    <section class="welcome">
        <div class="container py-3">
            <div class="row justify-content-center">
                <h4 class="border-bottom border-2 bg-main border-10 w-auto p-3 mb-5 shadow-soft fw-600"> Dashboard</h4>
                <h5 class="text-center fw-600">
                    Selamat Datang Di Dashboard Fazzblog, <?= $user ?>
                </h5>
            </div>
        </div>
    </section>


    <!-- konten -->
    <section class="dashboardKonten my-5">
        <div class="container mb-3">
            <div class="row align-items-center">
                <div class="col-12 col-md-6">
                    <h5 class="fw-bold text-center text-md-start">Postingan <?= $user ?> :
                        <span><?= $jmlPost['total'] ?></span>
                    </h5>
                </div>
                <div class="col-12 col-md-6">
                    <div class="d-flex justify-content-md-end justify-content-center">
                        <a href="laporan.php?penulis=<?= $user ?>&id_user=<?= $idUser ?>" class="cetakPost m-btn pri-btn font-15 fw-600 me-2" target="_blank">
                            <i class="fa-solid fa-print me-1"></i>
                            Cetak Laporan
                        </a>
                        <a href="tambahPostingan.php" class="postBaru m-btn pri-btn font-15 fw-600">
                            <i class="fa-solid fa-plus me-1"></i>
                            Postingan Baru
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container py-3 border-10 shadow-soft fw-bold">
            <div class="row">
                <div class="col-12 py-2 px-4">
                    <div class="table-responsive-sm">
                        <table class="table" style="color: #44476a;">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Judul Post</th>
                                    <th scope="col">Kategori</th>
                                    <th scope="col"><i class="fa-solid fa-gears me-1"></i> Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($jmlPost['total'] < 1) : ?>
                                    <tr>
                                        <td colspan="4">
                                            <span>Belum ada postingan</span>
                                        </td>
                                    </tr>
                                <?php else : ?>
                                    <?php foreach ($postingan as $key => $item) : ?>
                                        <tr>
                                            <th scope="row"><?= $key + 1 ?></th>
                                            <td><?= $item["judul"] ?></td>
                                            <td><?= $item["nama_kategori"] ?></td>
                                            <td>
                                                <a href="lihatPostingan.php?slug=<?= $item["slug"] ?>" class="m-btn pri-btn font-14 fw-600">
                                                    <i class="fa-solid fa-eye me-1"></i> Lihat
                                                </a>
                                                <a href="editPostingan.php?slug=<?= $item["slug"] ?>" class="m-btn pri-btn font-14 fw-600 mx-md-2">
                                                    <i class="fa-regular fa-pen-to-square me-1"></i> Edit
                                                </a>
                                                <a href="hapusPostingan.php?slug=<?= $item["slug"] ?>" class="m-btn pri-btn font-14 fw-600">
                                                    <i class="fa-solid fa-trash-can me-1"></i> Hapus
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php endif ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script type="text/javascript" src="../asset/js/bootstrap.bundle.js"></script>
    <script src="../asset/js/script.js"></script>
</body>

</html>