<?php
session_start();
include "../koneksi.php";

$user = $_SESSION["username"];

$kategori = mysqli_query($koneksi, "SELECT * FROM kategori_dindafazryan");

// Data postingan buat di sidebar
$postingan = mysqli_query($koneksi, "SELECT *
FROM postingan_dindafazryan
LEFT JOIN kategori_dindafazryan
ON postingan_dindafazryan.id_kategori = kategori_dindafazryan.id
LEFT JOIN user_dindafazryan
ON postingan_dindafazryan.id_user = user_dindafazryan.id LIMIT 5");


// Ambil postingan berdasarkan slug
$datas = mysqli_query($koneksi, "SELECT * 
FROM postingan_dindafazryan 
LEFT JOIN kategori_dindafazryan
ON postingan_dindafazryan.id_kategori = kategori_dindafazryan.id
LEFT JOIN user_dindafazryan
ON postingan_dindafazryan.id_user = user_dindafazryan.id 
WHERE slug = '$_GET[slug]'");
$data = mysqli_fetch_array($datas);

// Ambil komentar berdasarkan id_postingan yg dikirim
$komentar = mysqli_query($koneksi, "SELECT * 
FROM komentar_dindafazryan 
LEFT JOIN user_dindafazryan
ON komentar_dindafazryan.id_user_komentar = user_dindafazryan.id
WHERE id_postingan = '$_GET[id_postingan]'");

// Hitung total komentar postingan
$jmlKomentar = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM komentar_dindafazryan 
LEFT JOIN postingan_dindafazryan
ON komentar_dindafazryan.id_postingan = postingan_dindafazryan.id_postingan
WHERE komentar_dindafazryan.id_postingan = '$_GET[id_postingan]'");
$jmlKomen = mysqli_fetch_array($jmlKomentar);


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
    <title><?= $data['judul'] ?></title>
</head>

<body>
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
                        <a class="nav-link fw-600 font-15 mx-0 mx-lg-2 active" href="../index.php">Home</a>
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
                                <li><a class="dropdown-item" href="postByKategori.php?id_kategori=<?= $item["id"] ?>"><?= $item["nama_kategori"] ?></a></li>
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
                                <li><a class="dropdown-item font-14" href="../dashboard/index.php"><i class="fa-solid fa-chart-line me-1"></i> Dashboard</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item font-14" href="../otentikasi/logout.php"><i class="fa-solid fa-arrow-right-from-bracket me-1"></i> Logout</a></li>
                            </ul>
                        </li>
                    <?php else : ?>
                        <li class="nav-item mx-lg-2">
                            <a class="m-btn pri-btn font-15 fw-600" href="../otentikasi/login.php">
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

    <!-- Konten -->
    <section class="postingan" id="postingan">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="row mb-2">
                        <div class="col-12 col-md-7">
                            <div class="text-center text-md-start order-lg-2">
                                <nav aria-label="breadcrumb ">
                                    <div class="breadcrumb justify-content-center justify-content-md-start">
                                        <div class="font-14">
                                            <a href="../index.php" class="text-decoration-none txt-dark router-link-active">
                                                <i class="fa-solid fa-house"></i>
                                                Home &gt;
                                            </a>
                                        </div>
                                        <div aria-current="page" class="font-14 ms-1"> <?= $data["judul"] ?></div>
                                    </div>
                                </nav>
                            </div>
                        </div>
                        <div class="col-12 col-md-5">
                            <form action="../artikel/search.php" method="get">
                                <div class="d-flex mb-3">
                                    <input type="text" class="f-form me-2" name="keyword" placeholder="Cari artikel di Fazzblog" autocomplete="off" required>
                                    <button class="m-btn pri-btn" type="submit">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card-1 mb-3 border-10">
                                <div class="card-body p-0">
                                    <h3 class=""><?= $data["judul"] ?></h3>
                                    <div class="d-sm-flex justify-content-between align-items-center mb-3">
                                        <span class="fw-400 font-14  card-info">
                                            <i class="fa-regular fa-calendar-check me-2"></i>
                                            <?= date("d M Y", strtotime($data["created_at"])) ?>
                                            Oleh <a href="" class="text-slug"><?= $data["username"] ?></a>
                                        </span>
                                    </div>
                                    <div class="d-flex mx-auto my-4 detail-post-img">
                                        <img src="../fileUploadGambar/<?= $data["gambar"] ?>" class="w-100 rounded-3" alt="">
                                    </div>
                                    <p class=""><?= $data["body"] ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Postingan Sidebar -->
                <div class="col-lg-3">
                    <h4 class="mt-4 mt-lg-0" style="margin-bottom: 30px;">Baca Juga</h4>
                    <?php foreach ($postingan as $item) : ?>
                        <!-- Tampilan Untuk Desktop -->
                        <div class="shadow-soft border-10 mb-3 d-none d-md-none d-lg-block">
                            <div class="d-block d-sm-flex justify-content-center p-2 p-lg-1">
                                <img src="../fileUploadGambar/<?= $item['gambar'] ?>" class="rounded-3 d-lg-none d-xl-block" alt="gambar" style="width:45%;">
                                <div class="p-1 ms-1">
                                    <a href="postingan.php?slug=<?= $item['slug'] ?>&id_postingan=<?= $item['id_postingan'] ?>" class="text-slug">
                                        <h5 class="card-title font-14"><?= $item['judul'] ?></h5>
                                    </a>
                                    <span class="fw-600 card-info" style="font-size: 11px;">
                                        Oleh <a href="" class="text-slug"><?= $item["username"] ?></a>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Tampilan Untuk Tablet -->
                        <div class="col-12 d-lg-none">
                            <div class="card shadow-soft mb-3">
                                <div class="d-md-flex">
                                    <a href="postingan.php?slug=<?= $item['slug'] ?>&id_postingan=<?= $item['id_postingan'] ?>" class="my-md-4 ms-md-3">
                                        <img src="../fileUploadGambar/<?= $item['gambar'] ?>" class="rounded-3 post-img" alt="gambar">
                                    </a>
                                    <div class="card-body me-lg-3">
                                        <a href="postingan.php?slug=<?= $item['slug'] ?>&id_postingan=<?= $item['id_postingan'] ?>" class="text-slug">
                                            <h4 class="card-title">
                                                <?= $item["judul"] ?>
                                            </h4>
                                        </a>
                                        <p class="card-text mb-1 mb-md-1 mb-xl-3"><?= substr($item["body"], 60, 160) ?>...</p>
                                        <div class="d-sm-flex justify-content-between align-items-center">
                                            <span class="fw-600 font-15  card-info">
                                                <?= date("d M Y", strtotime($item["created_at"])) ?>
                                                Oleh <a href="" class="text-slug"><?= $item["username"] ?></a>
                                            </span>
                                            <div class="d-flex justify-content-between align-items-center card-info mt-3 mt-md-0">
                                                <span class="m-btn pri-btn font-14"><i class="fa-solid fa-comment me-1"></i> 3</span>
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

    <!-- Komentar -->
    <section class="komentar my-5" id="komentar">
        <div class="container py-3 shadow-soft" style="border-radius: 10px;">
            <div class="row">
                <div class="col-lg-8">
                    <div class="text-center text-md-start p-3">
                        <h4 class="pb-2">Komentar :
                            <?php if ($jmlKomen['total'] < 1) : ?>
                                <span>0</span>
                            <?php else : ?>
                                <span><?= $jmlKomen['total'] ?></span>
                            <?php endif ?>
                        </h4>
                        <div class="my-4 text-start">
                            <?php foreach ($komentar as $komen) : ?>
                                <div>
                                    <h6 class="fw-600 d-inline" style="color: rgb(78, 84, 200);"><?= $komen['username'] ?> -
                                        <span class="mt-1" style="font-size: 13px;"> <?= date("d M Y", strtotime($komen["tgl_pesan"])) ?></span>
                                    </h6>
                                    <p class="pb-2 mt-2" style="font-size: 15px;"><?= $komen['pesan'] ?></p>
                                    <hr>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card-body">
                        <h4 class="card-title text-center text-md-start mb-3">Tulis Komentar</h4>
                        <?php if ($user) : ?>
                            <p>Beri komentar sebagai
                                <b><?= $user ?></b>
                            </p>
                        <?php else : ?>
                            <p>*Anda harus login terlebih dahulu!</p>
                        <?php endif ?>
                        <form action="../komentar/tambahKomentar.php" method="post">

                            <div class="form-floating mb-3">
                                <input type="hidden" value="<?= $_GET["id_postingan"] ?>" name="id_postingan">
                                <textarea rows="5" autocomplete="off" class="f-form" name="pesan" placeholder="Pesan" required style="height: 130px"></textarea>
                            </div>
                            <button type="submit" class="m-btn pri-btn w-100 fw-600" name="kirimKomentar">Kirim Komentar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <?php include "../footer.php" ?>
    </section>
    <script type="text/javascript" src="../asset/js/bootstrap.bundle.js"></script>
    <script src="../asset/js/script.js"></script>
</body>

</html>