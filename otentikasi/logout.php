<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('location:login.php');
}

session_destroy();

echo "
    <script>
        alert('Berhasil Logout!'); 
        window.location ='login.php';
    </script>";
