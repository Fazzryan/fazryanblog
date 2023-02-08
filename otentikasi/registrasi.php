<?php
session_start();
include "../koneksi.php";
$kategori = mysqli_query($koneksi, "SELECT * FROM kategori_dindafazryan");
if (!empty($_SESSION['username']) and !empty($_SESSION['password'])) {
    header('location:index.php');
} else {

    if (isset($_POST["registrasi"])) {

        $password = $_POST["password"];
        $konfirmasiPassword = $_POST["confirmPassword"];

        if ($password != $konfirmasiPassword) {
            echo "
            <script>
                alert('Password tidak sesuai!');
                window.reload();
            </script>
        ";
        } else {
            $password = md5($_POST["password"]);
            $query = mysqli_query($koneksi, "INSERT INTO user_dindafazryan (id, username, email, password) VALUES ('','$_POST[username]','$_POST[email]','$password')");

            if ($query) {
                echo "
            <script>
                alert('Berhasil membuat akun!');
                window.location='login.php';
            </script>
            ";
            } else {
                echo "
                <script>
                    alert('Registrasi Gagal!');
                </script>
            ";
            }
        }
    }
}

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
    <title>Registrasi - Fazzblog</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light py-3 fixed-top">
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
                                <li><a class="dropdown-item" href="../postingan/postByKategori.php?id_kategori=<?= $item["id"] ?>"><?= $item["nama_kategori"] ?></a></li>
                            <?php endforeach ?>
                        </ul>
                    </li>
                </ul>
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <?php if (isset($_SESSION["username"])) : ?>
                        <li class="nav-item dropdown">
                            <a class="m-btn pri-btn fw-600 font-15 dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Hallo, <?= $user ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="dashboard/index.php">Dashboard</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="otentikasi/logout.php">Logout</a></li>
                            </ul>
                        </li>
                    <?php else : ?>
                        <li class="nav-item mx-lg-2">
                            <a class="m-btn pri-btn font-15" href="login.php">
                                <i class="fa-solid fa-arrow-right-to-bracket me-1"></i>
                                Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="m-btn pri-btn fw-600 font-15 mt-2 mt-lg-0" href="registrasi.php">
                                Registrasi Gratis
                            </a>
                        </li>
                    <?php endif ?>
                </ul>
            </div>
        </div>
    </nav>

    <section class="register" id="register">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-6 col-md-8">
                    <div class="card shadow-soft px-md-4 px-lg-5 py-3 px-3">
                        <form action="registrasi.php" method="post">
                            <h3 class="fw-400 mb-3 text-center">Registrasi</h3>

                            <label for="Username" class="mb-2">Username</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text txt-dark bgr-main">
                                        <i class="fa-solid fa-lock"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control form-1" name="username" required autocomplete="off" autofocus placeholder="Username">
                            </div>
                            <label for="Email" class="mb-2">Email</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text txt-dark bgr-main">
                                        <i class="fa-solid fa-envelope"></i>
                                    </span>
                                </div>
                                <input type="email" class="form-control form-1" name="email" required autocomplete="off" placeholder="Email">
                            </div>
                            <label for="Password" class="mb-2">Password</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text txt-dark bgr-main">
                                        <i class="fa-solid fa-lock"></i>
                                    </span>
                                </div>
                                <input type="password" class="form-control form-1" name="password" required placeholder="Password">
                            </div>
                            <label for="Confirmasi Passwor" class="mb-2">Konfirmasi Password</label>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text txt-dark bgr-main">
                                        <i class="fa-solid fa-lock"></i>
                                    </span>
                                </div>
                                <input type="password" class="form-control form-1" name="confirmPassword" required placeholder="Password">
                            </div>
                            <button type="submit" class="m-btn pri-btn mb-3 w-100" name="registrasi">Registrasi</button>
                            <p class="text-center font-14"> Sudah punya akun? <a href="login.php" class="text-slug">Login</a></p>
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
</body>

</html>