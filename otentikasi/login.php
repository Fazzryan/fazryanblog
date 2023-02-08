<?php
session_start();
include "../koneksi.php";
$kategori = mysqli_query($koneksi, "SELECT * FROM kategori_dindafazryan");
if (!empty($_SESSION['username']) and !empty($_SESSION['password'])) {
    header('location:index.php');
} else {
    if (isset($_POST["login"])) {

        // $username = $_POST["username"];
        $email = $_POST['email'];
        $password = md5($_POST["password"]);

        $query = mysqli_query($koneksi, "SELECT * FROM user_dindafazryan WHERE email = '$email' AND password = '$password'");
        $data = mysqli_fetch_array($query);

        if (empty($data["email"])) {
            echo "
            <script>
                alert('Login Gagal!');
            </script>
            ";
        } else {
            $_SESSION['id'] = $data['id'];
            $_SESSION['username'] = $data['username'];
            $_SESSION['email'] = $data['email'];
            $_SESSION['password'] = $data['password'];

            echo "
                <script>
                    alert('Login Berhasil!');
                    window.location='../index.php';
                </script>
            ";
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
    <title>Login - Fazzblog</title>
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
                            <a class="m-btn pri-btn fW-600 font-15 dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
                            <a class="m-btn pri-btn fw-600 font-15  mt-2 mt-lg-0" href="registrasi.php">
                                Registrasi Gratis
                            </a>
                        </li>
                    <?php endif ?>
                </ul>
            </div>
        </div>
    </nav>

    <section class="login" id="login">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-8">
                    <div class="card shadow-soft px-md-4 px-lg-5 py-3 px-3">
                        <form action="login.php" method="post" class="my-lg-3">
                            <h3 class="fw-400 mb-3 text-center">Login</h3>
                            <div class="mb-3 font-14">Login disini menggunakan email dan password anda.</div>
                            <label for="email" class="font-14 mb-2">Email</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text txt-dark bgr-main"><i class="fa-solid fa-envelope"></i></span>
                                </div>
                                <input type="text" class="form-control" placeholder="Email" name="email" required autocomplete="off" autofocus>
                            </div>

                            <label for="password" class="font-14 mb-2">Password</label>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text txt-dark bgr-main"><i class="fa-solid fa-lock"></i></span>
                                </div>
                                <input type="password" class="form-control" placeholder="Password" name="password" required>
                            </div>

                            <button type="submit" class="m-btn pri-btn mb-3 w-100" name="login">Login</button>
                            <p class="font-14 text-center mt-2">Beluma punya akun? <a href="registrasi.php" class="text-slug">Registrasi</a></p>
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