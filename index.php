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

// postingan sidebar
$postinganSidebar = mysqli_query($koneksi, "SELECT *
FROM postingan_dindafazryan
LEFT JOIN kategori_dindafazryan
ON postingan_dindafazryan.id_kategori = kategori_dindafazryan.id
LEFT JOIN user_dindafazryan
ON postingan_dindafazryan.id_user = user_dindafazryan.id LIMIT 5");

// postingan terbaru
$postingan = mysqli_query($koneksi, "SELECT *
FROM postingan_dindafazryan
LEFT JOIN kategori_dindafazryan
ON postingan_dindafazryan.id_kategori = kategori_dindafazryan.id
LEFT JOIN user_dindafazryan
ON postingan_dindafazryan.id_user = user_dindafazryan.id 
ORDER BY created_at DESC LIMIT 4");

// postingan berdasarkan teknologi
$postinganTeknologi = mysqli_query($koneksi, "SELECT * 
FROM postingan_dindafazryan
LEFT JOIN kategori_dindafazryan
ON postingan_dindafazryan.id_kategori = kategori_dindafazryan.id
LEFT JOIN user_dindafazryan
ON postingan_dindafazryan.id_user = user_dindafazryan.id 
where nama_kategori = 'Teknologi'
ORDER BY created_at DESC LIMIT 4
");

// postingan berdasarkan gadget
$postinganGadget = mysqli_query($koneksi, "SELECT * 
FROM postingan_dindafazryan
LEFT JOIN kategori_dindafazryan
ON postingan_dindafazryan.id_kategori = kategori_dindafazryan.id
LEFT JOIN user_dindafazryan
ON postingan_dindafazryan.id_user = user_dindafazryan.id 
where nama_kategori = 'Gadget'
ORDER BY created_at DESC LIMIT 4
");

// postingan berdasarkan komputer
$postinganKomputer = mysqli_query($koneksi, "SELECT * 
FROM postingan_dindafazryan
LEFT JOIN kategori_dindafazryan
ON postingan_dindafazryan.id_kategori = kategori_dindafazryan.id
LEFT JOIN user_dindafazryan
ON postingan_dindafazryan.id_user = user_dindafazryan.id 
where nama_kategori = 'Komputer'
ORDER BY created_at DESC LIMIT 4
");

// postingan berdasarkan internet
$postinganInternet = mysqli_query($koneksi, "SELECT * 
FROM postingan_dindafazryan
LEFT JOIN kategori_dindafazryan
ON postingan_dindafazryan.id_kategori = kategori_dindafazryan.id
LEFT JOIN user_dindafazryan
ON postingan_dindafazryan.id_user = user_dindafazryan.id 
where nama_kategori = 'Internet'
ORDER BY created_at DESC LIMIT 4
");


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
    <title>Home - Fazzblog</title>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light py-3 fixed-top nav-bar">
        <div class="container">
            <!-- <a class="navbar-brand fw-bold m-btn pri-btn" href="index.php">Fazzblog</a> -->
            <a class="navbar-brand fw-bold m-btn pri-btn" href="index.php">
                <img src="asset/img/logo.png" alt="logo" width="35">
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
                        <a class="nav-link m-btn pri-btn dropdown-toggle px-2 fw-600" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            Kategori
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <?php foreach ($kategori as $item) : ?>
                                <li>
                                    <a class="dropdown-item" href="postingan/postByKategori.php?id_kategori=<?= $item["id"] ?>"><?= $item["nama_kategori"] ?></a>
                                </li>
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

    <!-- Banner -->
    <section class="banner py-3" id="banner">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-lg-6 ">
                    <h1 class="fw-bold display-5 mb-4">Selamat datang di Fazzblog.</h1>
                    <p class="fw-400  mb-4 ">Fazzblog adalah website yang memiliki beberapa artikel untuk kamu yang suka membaca. Ada kategori menarik yang bisa kamu pilih. Selain itu, buat kamu yang hobby menulis kamu juga bisa menulis artikel kamu sendiri hanya dengan registrasi saja. Tunggu apalagi buat akun kamu sekarang juga!</p>
                    <a href="otentikasi/registrasi.php" class="m-btn pri-btn fw-600 px-3">
                        <i class="fa fa-user-plus me-1"></i>
                        Buat akun
                    </a>
                    <div class="mt-5 icon">
                        <p>Follow Sosial Media</p>
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
                </div>
                <div class="col-lg-6 text-end d-none d-lg-block">
                    <img src="asset/img/undraw_information.svg" class="w-75" alt="gambar">
                </div>
            </div>
        </div>
    </section>

    <!-- Artikel Terbaru -->
    <section class="postingan my-5" id="postingan">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="row mb-2">
                        <div class="col-12 col-md-7 order-1 order-md-0">
                            <h4 class="">Artikel Terbaru</h4>
                        </div>
                        <div class=" col-12 col-md-5">
                            <form action="artikel/search.php" method="get">
                                <div class="d-flex mb-3">
                                    <input type="text" class="f-form me-2" name="keyword" placeholder="Cari artikel di Fazzblog" autocomplete="off" required>
                                    <button class="m-btn pri-btn" type="submit">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Postingan Terbaru -->
                    <div class="row">
                        <?php foreach ($postingan as $item) : ?>
                            <div class="col-12">
                                <div class="card shadow-soft mb-3 py-md-3">
                                    <div class="d-md-flex">
                                        <a href="postingan/postingan.php?slug=<?= $item['slug'] ?>&id_postingan=<?= $item['id_postingan'] ?>" class=" my-md-4 ms-md-3">
                                            <img src="fileUploadGambar/<?= $item['gambar'] ?>" class="rounded-3 p-3 p-md-0 post-img" alt="gambar">
                                        </a>
                                        <div class="card-body me-lg-3">
                                            <a href="postingan/postingan.php?slug=<?= $item['slug'] ?>&id_postingan=<?= $item['id_postingan'] ?>" class="text-slug">
                                                <h4 class="card-title">
                                                    <?= $item["judul"] ?>
                                                </h4>
                                            </a>
                                            <p class="card-text mb-1 mb-md-1 mb-xl-3"><?= substr($item["body"], 3, 150) ?>...</p>
                                            <div class="d-sm-flex justify-content-between align-items-center mt-3">
                                                <span class="fw-600 font-15 card-info">
                                                    <?= date("d M Y", strtotime($item["created_at"])) ?>
                                                    Oleh <a href="penulis/postByPenulis.php?id=<?= $item['id_user'] ?>" class="text-slug"><?= $item["username"] ?></a>
                                                </span>
                                                <div class="d-flex justify-content-between align-items-center mt-3 mt-md-0">
                                                    <span class="m-btn shadow-small font-14"><i class="fa-solid fa-comment me-1"></i>
                                                        <?php
                                                        // Hitung total komentar postingan
                                                        $jmlKomentar = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM komentar_dindafazryan LEFT JOIN postingan_dindafazryan ON komentar_dindafazryan.id_postingan = postingan_dindafazryan.id_postingan WHERE komentar_dindafazryan.id_postingan = '$item[id_postingan]'");
                                                        $jmlKomen = mysqli_fetch_array($jmlKomentar); ?>
                                                        <?= $jmlKomen['total'] ?>
                                                    </span>
                                                    <div class="ms-3">
                                                        <a href="postingan/postByKategori.php?id_kategori=<?= $item["id_kategori"] ?>" class="m-btn pri-btn font-14"><?= $item["nama_kategori"] ?></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>


                <!-- Postingan Sidebar -->
                <div class="col-lg-3">
                    <h4 class="mt-4 mt-lg-0" style="margin-bottom: 30px;">Baca Juga</h4>
                    <?php foreach ($postinganSidebar as $item) : ?>
                        <!-- Tampilan Untuk Desktop -->
                        <div class="border-10 mb-3 d-none d-md-none d-lg-block">
                            <div class="d-block d-sm-flex justify-content-center p-2 p-lg-1">
                                <img src="fileUploadGambar/<?= $item['gambar'] ?>" class="rounded-3 d-lg-none d-xl-block" alt="gambar" style="width:45%;">
                                <div class="p-1 ms-1">
                                    <a href="postingan/postingan.php?slug=<?= $item['slug'] ?>&id_postingan=<?= $item['id_postingan'] ?>" class="text-slug">
                                        <h5 class="card-title font-14"><?= $item['judul'] ?></h5>
                                    </a>
                                    <span class="fw-600 card-info" style="font-size: 11px;">
                                        Oleh <a href="penulis/postByPenulis.php?id=<?= $item['id_user'] ?>" class="text-slug"><?= $item["username"] ?></a>
                                    </span>
                                </div>
                            </div>
                            <hr class="d-xl-none">
                        </div>

                        <!-- Tampilan Untuk Tablet -->
                        <div class="col-12 d-lg-none">
                            <div class="card shadow-soft mb-3">
                                <div class="d-md-flex">
                                    <a href="postingan/postingan.php?slug=<?= $item['slug'] ?>&id_postingan=<?= $item['id_postingan'] ?>" class=" my-md-4 ms-md-3">
                                        <img src="fileUploadGambar/<?= $item['gambar'] ?>" class="post-img p-3 p-md-0" alt="gambar">
                                    </a>
                                    <div class="card-body me-lg-3">
                                        <a href="postingan/postingan.php?slug=<?= $item['slug'] ?>&id_postingan=<?= $item['id_postingan'] ?>" class="text-slug">
                                            <h4 class="card-title">
                                                <?= $item["judul"] ?>
                                            </h4>
                                        </a>
                                        <p class="card-text mb-1 mb-md-1 mb-xl-3"><?= substr($item["body"], 60, 160) ?>...</p>
                                        <div class="d-sm-flex justify-content-between align-items-center mt-3">
                                            <span class="fw-600 font-15 card-info">
                                                <?= date("d M Y", strtotime($item["created_at"])) ?>
                                                Oleh <a href="penulis/postByPenulis.php?id=<?= $item['id_user'] ?>" class="text-slug"><?= $item["username"] ?></a>
                                            </span>
                                            <div class="d-flex justify-content-between align-items-center mt-3 mt-md-0">
                                                <span class="m-btn shadow-small font-14"><i class="fa-solid fa-comment me-1"></i>
                                                    <?php
                                                    // Hitung total komentar postingan
                                                    $jmlKomentar = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM komentar_dindafazryan LEFT JOIN postingan_dindafazryan ON komentar_dindafazryan.id_postingan = postingan_dindafazryan.id_postingan WHERE komentar_dindafazryan.id_postingan = '$item[id_postingan]'");
                                                    $jmlKomen = mysqli_fetch_array($jmlKomentar); ?>
                                                    <?= $jmlKomen['total'] ?>
                                                </span>
                                                <div class="mx-2">
                                                    <a href="" class="m-btn pri-btn font-14"><?= $item["nama_kategori"] ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
    </section>

    <!-- Teknologi -->
    <section class="postinganTeknologi" id="postTekno">
        <div class="container">
            <div class="row mb-4 align-items-center">
                <div class="col-6 col-md-7">
                    <h4>Teknologi</h4>
                </div>
                <div class="col-6 col-md-5 text-end">
                    <a href="postingan/postByKategori.php?id_kategori=4" class="text-slug">Lihat semua <i class="fa-solid fa-arrow-right ms-1"></i></a>
                </div>
            </div>

            <div class="row">
                <?php foreach ($postinganTeknologi as $item) : ?>
                    <div class="col-xl-3 col-lg-6 col-md-6 my-2">
                        <div class="card shadow-soft">
                            <a href="postingan/postingan.php?slug=<?= $item["slug"] ?>&id_postingan=<?= $item["id_postingan"] ?>">
                                <img src="fileUploadGambar/<?= $item["gambar"] ?>" class="w-100 p-3" style="border-radius:25px;" alt="gambar">
                            </a>
                            <div class="card-body">
                                <div class="d-md-flex d-none mb-2">
                                    <span class="fw-600 font-12 card-info">
                                        <?= date("d M Y", strtotime($item["created_at"])) ?>
                                        Oleh <a href="penulis/postByPenulis.php?id=<?= $item['id_user'] ?>" class="text-slug"><?= $item["username"] ?></a>
                                    </span>
                                </div>
                                <a href="postingan/postingan.php?slug=<?= $item['slug'] ?>&id_postingan=<?= $item['id_postingan'] ?>" class="text-slug">
                                    <h5 class="card-title font-16">
                                        <?= $item["judul"] ?>
                                    </h5>
                                </a>
                                <p class="card-text mb-1 mb-md-1 mb-xl-3 font-13 fw-500"><?= substr($item["body"], 3, 110) ?>...</p>
                                <div class="d-sm-flex justify-content-between align-items-center">
                                    <span class="d-none d-md-block m-btn shadow-small font-12"><i class="fa-solid fa-comment me-1"></i>
                                        <?php
                                        // Hitung total komentar postingan
                                        $jmlKomentar = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM komentar_dindafazryan LEFT JOIN postingan_dindafazryan ON komentar_dindafazryan.id_postingan = postingan_dindafazryan.id_postingan WHERE komentar_dindafazryan.id_postingan = '$item[id_postingan]'");
                                        $jmlKomen = mysqli_fetch_array($jmlKomentar);
                                        ?>
                                        <?= $jmlKomen['total'] ?>
                                    </span>
                                    <div class="d-sm-flex justify-content-between align-items-center">
                                        <span class="fw-600 font-12 card-info d-md-none">
                                            <?= date("d M Y", strtotime($item["created_at"])) ?>
                                            Oleh <a href="penulis/postByPenulis.php?id=<?= $item['id_user'] ?>" class="text-slug"><?= $item["username"] ?></a>
                                        </span>
                                        <div class="d-flex justify-content-between align-items-center mt-3 mt-md-0 card-info">
                                            <span class="d-md-none m-btn shadow-small font-12"><i class="fa-solid fa-comment me-1"></i>
                                                <?php
                                                // Hitung total komentar postingan
                                                $jmlKomentar = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM komentar_dindafazryan LEFT JOIN postingan_dindafazryan ON komentar_dindafazryan.id_postingan = postingan_dindafazryan. id_postingan WHERE komentar_dindafazryan.id_postingan = '$item[id_postingan]'");
                                                $jmlKomen = mysqli_fetch_array($jmlKomentar);
                                                ?>
                                                <?= $jmlKomen['total'] ?>
                                            </span>
                                            <div class="ms-3">
                                                <a href="postingan/postByKategori.php?id_kategori=<?= $item["id_kategori"] ?>" class="m-btn pri-btn rounded-pill font-12"><?= $item["nama_kategori"] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
    </section>

    <!-- Gadget -->
    <section class="postinganGadget mt-5" id="postGadget">
        <div class="container">
            <div class="row mb-4">
                <div class="col-6 col-md-7">
                    <h4 class="">Gadget</h4>
                </div>
                <div class="col-6 col-md-5 text-end">
                    <a href="postingan/postByKategori.php?id_kategori=3" class="text-slug">Lihat semua <i class="fa-solid fa-arrow-right ms-1"></i></a>
                </div>
            </div>

            <div class="row">
                <?php foreach ($postinganGadget as $item) : ?>
                    <div class="col-xl-3 col-lg-6 col-md-6 my-2">
                        <div class="card shadow-soft">
                            <a href="postingan/postingan.php?slug=<?= $item["slug"] ?>&id_postingan=<?= $item["id_postingan"] ?>">
                                <img src="fileUploadGambar/<?= $item["gambar"] ?>" class="w-100 p-3" style="border-radius:25px;" alt="gambar">
                            </a>
                            <div class="card-body">
                                <div class="d-md-flex d-none mb-2">
                                    <span class="fw-600 font-12 card-info">
                                        <?= date("d M Y", strtotime($item["created_at"])) ?>
                                        Oleh <a href="penulis/postByPenulis.php?id=<?= $item['id_user'] ?>" class="text-slug"><?= $item["username"] ?></a>
                                    </span>
                                </div>
                                <a href="postingan/postingan.php?slug=<?= $item['slug'] ?>&id_postingan=<?= $item['id_postingan'] ?>" class="text-slug">
                                    <h5 class="card-title font-16">
                                        <?= $item["judul"] ?>
                                    </h5>
                                </a>
                                <p class="card-text mb-1 mb-md-1 mb-xl-3 font-13 fw-500"><?= substr($item["body"], 3, 110) ?>...</p>
                                <div class="d-sm-flex justify-content-between align-items-center">
                                    <span class="d-none d-md-block m-btn shadow-small font-12"><i class="fa-solid fa-comment me-1"></i>
                                        <?php
                                        // Hitung total komentar postingan
                                        $jmlKomentar = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM komentar_dindafazryan LEFT JOIN postingan_dindafazryan ON komentar_dindafazryan.id_postingan = postingan_dindafazryan.id_postingan WHERE komentar_dindafazryan.id_postingan = '$item[id_postingan]'");
                                        $jmlKomen = mysqli_fetch_array($jmlKomentar); ?>
                                        <?= $jmlKomen['total'] ?>
                                    </span>
                                    <div class="d-sm-flex justify-content-between align-items-center">
                                        <span class="fw-600 font-12 card-info d-md-none">
                                            <?= date("d M Y", strtotime($item["created_at"])) ?>
                                            Oleh <a href="penulis/postByPenulis.php?id=<?= $item['id_user'] ?>" class="text-slug"><?= $item["username"] ?></a>
                                        </span>
                                        <div class="d-flex justify-content-between align-items-center mt-3 mt-md-0 card-info">
                                            <span class="d-md-none m-btn shadow-small font-12"><i class="fa-solid fa-comment me-1"></i>
                                                <?php
                                                // Hitung total komentar postingan
                                                $jmlKomentar = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM komentar_dindafazryan LEFT JOIN postingan_dindafazryan ON komentar_dindafazryan.id_postingan = postingan_dindafazryan.id_postingan WHERE komentar_dindafazryan.id_postingan = '$item[id_postingan]'");
                                                $jmlKomen = mysqli_fetch_array($jmlKomentar); ?>
                                                <?= $jmlKomen['total'] ?>
                                            </span>
                                            <div class="ms-3">
                                                <a href="postingan/postByKategori.php?id_kategori=<?= $item["id_kategori"] ?>" class="m-btn pri-btn rounded-pill font-12"><?= $item["nama_kategori"] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
    </section>

    <!-- Komputer -->
    <section class="postinganKomputer mt-5" id="postKomputer">
        <div class="container">
            <div class="row mb-4">
                <div class="col-6 col-md-7">
                    <h4 class="">Komputer</h4>
                </div>
                <div class="col-6 col-md-5 text-end">
                    <a href="postingan/postByKategori.php?id_kategori=2" class="text-slug">Lihat semua <i class="fa-solid fa-arrow-right ms-1"></i></a>
                </div>
            </div>

            <div class="row">
                <?php foreach ($postinganKomputer as $item) : ?>
                    <div class="col-xl-3 col-lg-6 col-md-6 my-2">
                        <div class="card shadow-soft">
                            <a href="postingan/postingan.php?slug=<?= $item["slug"] ?>&id_postingan=<?= $item["id_postingan"] ?>">
                                <img src="fileUploadGambar/<?= $item["gambar"] ?>" class="w-100 p-3" style="border-radius:25px;" alt="gambar">
                            </a>
                            <div class="card-body">
                                <div class="d-md-flex d-none mb-2">
                                    <span class="fw-600 font-12 card-info">
                                        <?= date("d M Y", strtotime($item["created_at"])) ?>
                                        Oleh <a href="penulis/postByPenulis.php?id=<?= $item['id_user'] ?>" class="text-slug"><?= $item["username"] ?></a>
                                    </span>
                                </div>
                                <a href="postingan/postingan.php?slug=<?= $item['slug'] ?>&id_postingan=<?= $item['id_postingan'] ?>" class="text-slug">
                                    <h5 class="card-title font-16">
                                        <?= $item["judul"] ?>
                                    </h5>
                                </a>
                                <p class="card-text mb-1 mb-md-1 mb-xl-3 font-13 fw-500"><?= substr($item["body"], 3, 110) ?>...</p>
                                <div class="d-sm-flex justify-content-between align-items-center">
                                    <span class="d-none d-md-block m-btn shadow-small font-12"><i class="fa-solid fa-comment me-1"></i>
                                        <?php
                                        // Hitung total komentar postingan
                                        $jmlKomentar = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM komentar_dindafazryan LEFT JOIN postingan_dindafazryan ON komentar_dindafazryan.id_postingan = postingan_dindafazryan.id_postingan WHERE komentar_dindafazryan.id_postingan = '$item[id_postingan]'");
                                        $jmlKomen = mysqli_fetch_array($jmlKomentar); ?>
                                        <?= $jmlKomen['total'] ?>
                                    </span>
                                    <div class="d-sm-flex justify-content-between align-items-center">
                                        <span class="fw-600 font-12 card-info d-md-none">
                                            <?= date("d M Y", strtotime($item["created_at"])) ?>
                                            Oleh <a href="penulis/postByPenulis.php?id=<?= $item['id_user'] ?>" class="text-slug"><?= $item["username"] ?></a>
                                        </span>
                                        <div class="d-flex justify-content-between align-items-center mt-3 mt-md-0 card-info">
                                            <span class="d-md-none m-btn shadow-small font-12"><i class="fa-solid fa-comment me-1"></i>
                                                <?php
                                                // Hitung total komentar postingan
                                                $jmlKomentar = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM komentar_dindafazryan LEFT JOIN postingan_dindafazryan ON komentar_dindafazryan.id_postingan = postingan_dindafazryan.id_postingan WHERE komentar_dindafazryan.id_postingan = '$item[id_postingan]'");
                                                $jmlKomen = mysqli_fetch_array($jmlKomentar); ?>
                                                <?= $jmlKomen['total'] ?>
                                            </span>
                                            <div class="ms-3">
                                                <a href="postingan/postByKategori.php?id_kategori=<?= $item["id_kategori"] ?>" class="m-btn pri-btn rounded-pill font-12"><?= $item["nama_kategori"] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
    </section>

    <!-- Internet -->
    <section class="postinganInternet mt-5" id="postInternet">
        <div class="container">
            <div class="row mb-4">
                <div class="col-6 col-md-7">
                    <h4 class="">Internet</h4>
                </div>
                <div class="col-6 col-md-5 text-end">
                    <a href="postingan/postByKategori.php?id_kategori=1" class="text-slug">Lihat semua <i class="fa-solid fa-arrow-right ms-1"></i></a>
                </div>
            </div>

            <div class="row">
                <?php foreach ($postinganInternet as $item) : ?>
                    <div class="col-xl-3 col-lg-6 col-md-6 my-2">
                        <div class="card shadow-soft">
                            <a href="postingan/postingan.php?slug=<?= $item["slug"] ?>&id_postingan=<?= $item["id_postingan"] ?>">
                                <img src="fileUploadGambar/<?= $item["gambar"] ?>" class="w-100 p-3" style="border-radius:25px;" alt="gambar">
                            </a>
                            <div class="card-body">
                                <div class="d-md-flex d-none mb-2">
                                    <span class="fw-600 font-12 card-info">
                                        <?= date("d M Y", strtotime($item["created_at"])) ?>
                                        Oleh <a href="penulis/postByPenulis.php?id=<?= $item['id_user'] ?>" class="text-slug"><?= $item["username"] ?></a>
                                    </span>
                                </div>
                                <a href="postingan/postingan.php?slug=<?= $item['slug'] ?>&id_postingan=<?= $item['id_postingan'] ?>" class="text-slug">
                                    <h5 class="card-title font-16">
                                        <?= $item["judul"] ?>
                                    </h5>
                                </a>
                                <p class="card-text mb-1 mb-md-1 mb-xl-3 font-13 fw-500"><?= substr($item["body"], 3, 110) ?>...</p>
                                <div class="d-sm-flex justify-content-between align-items-center">
                                    <span class="d-none d-md-block m-btn shadow-small font-12"><i class="fa-solid fa-comment me-1"></i>
                                        <?php
                                        // Hitung total komentar postingan
                                        $jmlKomentar = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM komentar_dindafazryan LEFT JOIN postingan_dindafazryan ON komentar_dindafazryan.id_postingan = postingan_dindafazryan.id_postingan WHERE komentar_dindafazryan.id_postingan = '$item[id_postingan]'");
                                        $jmlKomen = mysqli_fetch_array($jmlKomentar); ?>
                                        <?= $jmlKomen['total'] ?>
                                    </span>
                                    <div class="d-sm-flex justify-content-between align-items-center">
                                        <span class="fw-600 font-12 card-info d-md-none">
                                            <?= date("d M Y", strtotime($item["created_at"])) ?>
                                            Oleh <a href="penulis/postByPenulis.php?id=<?= $item['id_user'] ?>" class="text-slug"><?= $item["username"] ?></a>
                                        </span>
                                        <div class="d-flex justify-content-between align-items-center mt-3 mt-md-0 card-info">
                                            <span class="d-md-none m-btn shadow-small font-12"><i class="fa-solid fa-comment me-1"></i>
                                                <?php
                                                // Hitung total komentar postingan
                                                $jmlKomentar = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM komentar_dindafazryan LEFT JOIN postingan_dindafazryan ON komentar_dindafazryan.id_postingan = postingan_dindafazryan.id_postingan WHERE komentar_dindafazryan.id_postingan = '$item[id_postingan]'");
                                                $jmlKomen = mysqli_fetch_array($jmlKomentar); ?>
                                                <?= $jmlKomen['total'] ?>
                                            </span>
                                            <div class="ms-3">
                                                <a href="postingan/postByKategori.php?id_kategori=<?= $item["id_kategori"] ?>" class="m-btn pri-btn rounded-pill font-12"><?= $item["nama_kategori"] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
    </section>

    <section>
        <?php include "footer.php" ?>
    </section>

    <script type="text/javascript" src="asset/js/bootstrap.bundle.js"></script>
    <script src="asset/js/script.js"></script>
</body>

</html>