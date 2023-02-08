<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['username'])) {
    header('location:../otentikasi/login.php');
}

$user = $_SESSION["username"];
$kategori = mysqli_query($koneksi, "SELECT * FROM kategori_dindafazryan");
$datas = mysqli_query($koneksi, "SELECT * 
FROM postingan_dindafazryan 
INNER JOIN kategori_dindafazryan
ON postingan_dindafazryan.id_kategori = kategori_dindafazryan.id
INNER JOIN user_dindafazryan
ON postingan_dindafazryan.id_user = user_dindafazryan.id 
WHERE slug = '$_GET[slug]'");

$data = mysqli_fetch_array($datas);


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
                                <li><a class="dropdown-item" href=""><?= $item["nama_kategori"] ?></a></li>
                            <?php endforeach ?>
                        </ul>
                    </li>
                </ul>
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <?php if (isset($_SESSION["username"])) : ?>
                        <li class="nav-item dropdown">
                            <a class="m-btn pri-btn py-2 px-3 fw-600 font-15 dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?= $user ?>
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

    <!-- <section class="welcome">
        <div class="container py-3">
            <div class="row justify-content-center">
                <h3 class="border-bottom border-2 bg-main border-10 w-auto p-3 mb-5"><i class="fa-solid fa-chart-line"></i> Dashboard</h3>
                <h5 class="text-center">
                    Selamat Datang Di Dashboard Anda, <?= $user ?>
                </h5>
            </div>
        </div>
    </section> -->

    <!-- konten -->
    <section class="postingan my-5">
        <div class="container mb-3">
            <div class="row justify-content-center">
                <div class="col-12 col-md-10 col-lg-8 mb-3">
                    <a href="index.php" class="m-btn pri-btn"><i class="fa-solid fa-arrow-left me-1"></i> Kembali</a>
                </div>
                <div class="col-12 col-md-10 col-lg-8 bg-main border-10 p-1">
                    <div class="card-1 mb-3">
                        <div class="card-body p-4">
                            <h3 class=""><?= $data["judul"] ?></h3>
                            <div class="d-sm-flex justify-content-between align-items-center mb-3">
                                <span class="fw-400 font-14  card-info">
                                    <i class="fa-regular fa-calendar-check me-2"></i>
                                    <?= date("d M Y", strtotime($data["created_at"])) ?>
                                    Oleh <a href="" class="text-slug"><?= $data["username"] ?></a>
                                </span>
                            </div>
                            <div class=" d-flex mx-auto my-4 detail-post-img">
                                <img src="../fileUploadGambar/<?= $data["gambar"] ?>" class="w-100 rounded-3" alt="">
                            </div>
                            <p class=""><?= $data["body"] ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script type="text/javascript" src="../asset/js/bootstrap.bundle.js"></script>
    <script src="../asset/js/script.js"></script>
</body>

</html>