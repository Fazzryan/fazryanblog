<?php
session_start();
include "../koneksi.php";

if (empty($_SESSION["username"])) {
    $user = "";
} else {
    $user = $_SESSION["username"];
}

$semuaKategori = mysqli_query($koneksi, "SELECT * FROM kategori_dindafazryan");

$id_kategori = $_GET["id_kategori"];
$kategori =  mysqli_query($koneksi, "SELECT * FROM kategori_dindafazryan WHERE id = '$id_kategori'");
$namaKategori = mysqli_fetch_array($kategori);

// Pagination
$batas = 4;
$halaman = isset($_GET["halaman"]) ? (int) $_GET["halaman"] : 1;
$halamanAwal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;

$back = $halaman - 1;
$next = $halaman + 1;

$postingan = mysqli_query($koneksi, "SELECT * 
FROM postingan_dindafazryan
LEFT JOIN user_dindafazryan
ON postingan_dindafazryan.id_user = user_dindafazryan.id 
LEFT JOIN kategori_dindafazryan
ON postingan_dindafazryan.id_kategori = kategori_dindafazryan.id 
WHERE id_kategori = '$id_kategori'

");

$jmlData = mysqli_num_rows($postingan);
$totalHalaman = $jmlData / $batas;
$nomor = $halamanAwal + 1;

$postinganPaging = mysqli_query($koneksi, "SELECT * 
FROM postingan_dindafazryan
LEFT JOIN user_dindafazryan
ON postingan_dindafazryan.id_user = user_dindafazryan.id 
LEFT JOIN kategori_dindafazryan
ON postingan_dindafazryan.id_kategori = kategori_dindafazryan.id 
WHERE id_kategori = '$id_kategori' ORDER BY id_postingan DESC 
LIMIT $halamanAwal, $batas
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
    <title><?= $namaKategori["nama_kategori"] ?> - Fazzblog</title>
</head>

<body>
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
                            <?php foreach ($semuaKategori as $item) : ?>
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
                            <a class="m-btn pri-btn fw-600 font-15" href="../otentikasi/login.php">
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

    <!-- Postingan -->
    <section class="postingan" id="postingan">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="row mb-2">
                        <div class="col-12 col-md-7 order-1 order-md-0">
                            <h5 class="">Menampilkan postingan dengan kategori <span class="fw-bold"> <?= $namaKategori["nama_kategori"] ?>.</span></h5>
                        </div>
                        <div class=" col-12 col-md-5">
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
                        <?php foreach ($postinganPaging as $item) : ?>
                            <div class="col-12">
                                <div class="card shadow-soft mb-3 py-md-3">
                                    <div class="d-md-flex">
                                        <a href="../postingan/postingan.php?slug=<?= $item['slug'] ?>&id_postingan=<?= $item['id_postingan'] ?>" class=" my-md-4 ms-md-3">
                                            <img src="../fileUploadGambar/<?= $item['gambar'] ?>" class="rounded-3 p-3 p-md-0 post-img" alt="gambar">
                                        </a>
                                        <div class="card-body me-lg-3">
                                            <a href="../postingan/postingan.php?slug=<?= $item['slug'] ?>&id_postingan=<?= $item['id_postingan'] ?>" class="text-slug">
                                                <h4 class="card-title">
                                                    <?= $item["judul"] ?>
                                                </h4>
                                            </a>
                                            <p class="card-text mb-1 mb-md-1 mb-xl-3"><?= substr($item["body"], 3, 150) ?>...</p>
                                            <div class="d-sm-flex justify-content-between align-items-center mt-3">
                                                <span class="fw-600 font-15 card-info">
                                                    <?= date("d M Y", strtotime($item["created_at"])) ?>
                                                    Oleh <a href="../penulis/postByPenulis.php?id=<?= $item['id_user'] ?>" class="text-slug"><?= $item["username"] ?></a>
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
                                                        <a href="" class="m-btn pri-btn font-14"><?= $item["nama_kategori"] ?></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php $nomor++ ?>
                        <?php endforeach ?>
                    </div>
                    <!-- Pagination -->
                    <div class="row mt-3 mb-4 mt-lg-2">
                        <div class="col-12">
                            <ul class="d-flex list-unstyled justify-content-center justify-content-md-start">
                                <a class="m-btn pri-btn me-1" style="border-top-right-radius: 0; border-bottom-right-radius: 0;" <?php if ($halaman > 1) {
                                                                                                                                        echo "href='?id_kategori=$id_kategori&halaman=$back'";
                                                                                                                                    } ?>>
                                    <i class="fa-solid fa-angles-left"></i>
                                </a>
                                <?php for ($i = 1; $i < $totalHalaman + 1; $i++) : ?>
                                    <li class="mx-1" id="page-sekarang">
                                        <a class="text-slug m-btn pri-btn rounded-0" id="" href="?id_kategori=<?= $id_kategori ?>&halaman=<?= $i ?>">
                                            <?= $i ?>
                                        </a>
                                    </li>
                                <?php endfor ?>
                                <a class="m-btn pri-btn ms-1" style="border-top-left-radius: 0; border-bottom-left-radius: 0;" <?php if ($halaman < $totalHalaman) {
                                                                                                                                    echo "href='?id_kategori=$id_kategori&halaman=$next'";
                                                                                                                                } ?>>
                                    <i class="fa-solid fa-angles-right"></i>
                                </a>
                            </ul>
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