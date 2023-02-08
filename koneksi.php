<?php

$host = "localhost";
$username = "root";
$password = "";
$db = "fazzblog_dindafazryan";

$koneksi = new mysqli($host, $username, $password, $db);

if (mysqli_connect_errno()) {
    trigger_error("Koneksi Gagal : " . mysqli_connect_error(), E_USER_ERROR);
}
