<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['username'])) {
    header('location:../otentikasi/login.php');
}

$user = $_SESSION["username"];

$kategori = mysqli_query($koneksi, "SELECT * FROM kategori_dindafazryan");

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
    <!-- Ck Editor -->
    <script src="../asset/library/vendor/ckeditor/ckeditor/ckeditor.js"></script>
    <title>Tambah Postingan Baru</title>
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
                            <a class="m-btn pri-btn font-15" href="otentikasi/login.php">
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


    <section class="welcome">
        <div class="container py-3">
            <div class="row justify-content-center">
                <h4 class="shadow-soft border-10 w-auto p-3 mb-5">Buat Postingan Baru</h4>
            </div>
        </div>
    </section>

    <section class="postinganBaru mb-5">
        <div class="container ">
            <div class="row justify-content-center">
                <div class="col-12 col-md-10 col-lg-8 mb-4" style="margin-left: -21px;">
                    <a href="index.php" class="m-btn pri-btn"><i class="fa-solid fa-arrow-left me-1"></i> Kembali</a>
                </div>
                <div class="col-12 col-md-10 col-lg-8 border-10 p-3 shadow-soft">
                    <form action="uploadPost.php" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="Judul" class="form-label">Judul Postingan</label>
                            <input type="text" class="f-form" name="judul" id="judul" required autocomplete="off" placeholder="Ini Contoh Judul" maxlength="60">
                        </div>
                        <div class="mb-3">
                            <label for="Slug" class="form-label">Slug</label>
                            <input type="text" class="f-form" name="slug" id="slug" required autocomplete="off" placeholder="ini-contoh-slug" readonly>
                            <p class="font-13 mt-2">*Slug akan terisi otomatis ketika judul di isi</p>
                        </div>
                        <div class="mb-3">
                            <label for="Kategori" class="form-label">Kategori</label>
                            <select class="form-select f-form" name="kategori" required autocomplete="off">
                                <option value="" class="" selected>Pilih Kategori</option>
                                <?php foreach ($kategori as $item) : ?>
                                    <option class="" value="<?= $item['id'] ?>"><?= $item['nama_kategori'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <label class="mb-2">Gambar</label>
                        <div class="custom-file mb-3">
                            <input type="file" name="gambar" id="gambar" class="custom-file-input" required>
                            <label for="Gambar" class="custom-file-label">Pilih Gambar</label>
                        </div>
                        <div class="mb-3">
                            <label for="Body" class="form-label">Body</label>
                            <textarea class="f-form bg-transparent rounded-3" name="body" id="ckeditor1" rows="3"></textarea>
                        </div>
                        <div class="d-flex justify-content-end mt-1">
                            <button type="submit" name="uploadPostingan" class="m-btn pri-btn font-15 fw-600 uploadPostingan">
                                Posting
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>


    <script>
        CKEDITOR.replace('ckeditor1');

        let inputSlug = document.getElementById('slug');
        let inputJudul = document.getElementById('judul');
        inputJudul.addEventListener("keyup", function() {
            let teks = inputJudul.value;
            teks = teks.replace(/\s+/g, '-').toLowerCase();
            inputSlug.value = teks;
        });

        let inputGambar = document.querySelector('.custom-file-input');
        let namaGambar = document.querySelector('.custom-file-label');
        inputGambar.addEventListener("change", function() {
            let inputImage = document.querySelector("input[type=file]").files[0];
            namaGambar.innerText = inputImage.name;
        });
    </script>
    <script type="text/javascript" src="../asset/js/bootstrap.bundle.js"></script>
    <script src="../asset/js/script.js"></script>
</body>

</html>