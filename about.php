<?php
session_start();
include "koneksi.php";

// $data = mysqli_query($koneksi, "SELECT * FROM user");
if (empty($_SESSION["username"])) {
    $user = "";
} else {
    $user = $_SESSION["username"];
}

$kategori = mysqli_query($koneksi, "SELECT * FROM kategori_dindafazryan");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap Css -->
    <link rel="stylesheet" href="asset/css/bootstrap.css">
    <!-- My Css -->
    <link rel="stylesheet" href="asset/css/style.css">
    <!-- Font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <title>Tentang Saya - Fazzblog</title>
</head>

<body style="margin-top: 120px;">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light py-3 fixed-top nav-bar">
        <div class="container">
            <a class="navbar-brand fw-bold m-btn pri-btn" href="index.php">
                <img src="asset/img/logo.png" alt="logo" width="35" style="background: transparent !important;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link fw-600 font-15 mx-0 mx-lg-2 active" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-600 font-15 mx-0 mx-lg-2" href="about.php">Tentang Saya</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link m-btn pri-btn dropdown-toggle px-2 fw-600" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Kategori
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <?php foreach ($kategori as $item) : ?>
                                <li><a class="dropdown-item" href="postingan/postByKategori.php?id_kategori=<?= $item["id"] ?>"><?= $item["nama_kategori"] ?></a></li>
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
                                <li><a class="dropdown-item font-14" href="dashboard/index.php"><i class="fa-solid fa-chart-line me-1"></i> Dashboard</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item font-14" href="otentikasi/logout.php"><i class="fa-solid fa-arrow-right-from-bracket me-1"></i> Logout</a></li>
                            </ul>
                        </li>
                    <?php else : ?>
                        <li class="nav-item mx-lg-2">
                            <a class="m-btn pri-btn fw-600 font-15" href="otentikasi/login.php">
                                <i class="fa-solid fa-arrow-right-to-bracket me-1"></i>
                                Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="m-btn pri-btn fw-600 font-15 mt-2 mt-lg-0" href="otentikasi/registrasi.php">
                                Registrasi Gratis
                            </a>
                        </li>
                    <?php endif ?>
                </ul>
            </div>
        </div>
    </nav>

    <sectoin>
        <div class="container">
            <div class="row justify-content-md-center justify-content-xl-start text-md-center text-xl-start">
                <div class="col-sm-6 col-md-8 col-lg-6">
                    <h3 class="fw-bold mb-3">Fazzblog</h3>
                    <p><b>Fazzblog</b> merupakan media untuk berbagi informasi atau ilmu tentang Teknologi, media komunikasi, internet dan lainnya. Apabila terdapat informasi dari artikel maupun yang lainnya yang salah, kurang pas atau kurang komplit. Hal tersebut merupakan keterbatasan dan kekurangan kami.</p>
                    <p></p>
                    <p>Tujuan dari pembuatan <b>Fazzblog</b> salah satunya adalah untuk memenuhi tugas Uas mata kuliah Pemrograman Web II, semester 5. Semoga blog ini memiliki manfaat kepada pembaca, setidaknya untuk saya sendiri sebagai pembuat fazzblog.</p>
                    <p>Terima kasih telah mengunjungi <b>Fazzblog.</b></p>
                </div>
                <div class="col-md-6 text-md-center d-none d-lg-block">
                    <img src="asset/img/undraw_team_work_k-80-m.svg" alt="profile" class="w-75">
                </div>
            </div>
        </div>
    </sectoin>

    <section class="my-5">
        <div class="container">
            <div class="row align-items-center align-items-lg-start">
                <div class="col-md-6 text-center text-lg-start">
                    <img src="asset/img/profile.png" alt="profile" class="w-75 border-10 p-3 shadow-soft-inset rounded-circle border-10">
                </div>
                <div class="col-md-6 mt-5">
                    <h3 class="fw-bold mb-3">Profile</h3>
                    <p>Hallo, saya <b>Dinda Fazryan</b></p>
                    <p>Saya seorang mahasiswa semester 5 di <a href="https://stmik-tasikmalaya.ac.id/new/" class="text-slug fw-bold">STMIK Tasikmalaya</a>. Saya senang belajar hal baru mengenai teknologi informasi, web dan mobile programming. Sekarang saya sedang memperdalam atau mempelajari bahasa pemrograman PHP - Laravel 8 dan juga Javascript - VueJs. Untuk selengkapnya silahkan follow sosial media saya dibawah ini.</p>
                    <div class="my-3 icon">
                        <div class="d-flex">
                            <a class="i-github m-btn pri-btn mx-1" target="_blank" href="https://github.com/fazzryan" data-bs-toggle="tooltip" data-bs-placement="top" title="Github">
                                <i class="fa-brands fa-github"></i>
                            </a>

                            <a class="i-ig m-btn pri-btn mx-1" target="_blank" href="https://www.instagram.com/fazzryan.c" data-bs-toggle="tooltip" data-bs-placement="top" title="Instagram">
                                <i class="fa-brands fa-instagram"></i>
                            </a>

                            <a class="i-fb m-btn pri-btn mx-1" target="_blank" href="https://web.facebook.com/fazryan.c09/" data-bs-toggle="tooltip" data-bs-placement="top" title="Facebook">
                                <i class="fa-brands fa-facebook"></i>
                            </a>

                            <a class="i-yt m-btn pri-btn mx-1" target="_blank" href="https://www.youtube.com/channel/UCS267HKSoEyTqFMgxpCB3Tw/featured" data-bs-toggle="tooltip" data-bs-placement="top" title="Youtube">
                                <i class="fa-brands fa-youtube"></i>
                            </a>
                        </div>
                    </div>
                    <p>Terima kasih!</p>
                </div>
            </div>
        </div>
    </section>

    <section>
        <?php include "footer.php" ?>
    </section>

    <script type="text/javascript" src="asset/js/bootstrap.bundle.js"></script>
    <script src="asset/js/script.js"></script>
</body>

</html>