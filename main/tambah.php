<?php
include "config/koneksi.php";

if (isset($_POST['tambah'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $no_telp = $_POST['no_telp'];
    $alamat = $_POST['alamat'];

    $result = mysqli_query($conn, "INSERT INTO operator (username, email, password, jenis_kelamin, no_telp, alamat) VALUES ('$username', '$email', '$password', '$jenis_kelamin', '$no_telp', '$alamat')");

    if ($result) {
        echo "<script>window.location.href='home_admin.php';</script>";
    } else {
        echo "<script>alert('Data gagal ditambahkan!');</script>";
        echo "<script>window.location.href='home_admin.php';</script>";
    }
}

elseif (isset($_POST['tambah_parkir'])) {
    date_default_timezone_set('Asia/Jakarta');

    $id_parkir = "IP".rand(100, 999);
    $plat_nomor = $_POST['plat_nomor'];
    $merk = $_POST['merk'];
    $jenis_kendaraan = $_POST['jenis_kendaraan'];
    $status_parkir = "Sedang Parkir";

    $result = mysqli_query($conn, "INSERT INTO parkir (id_parkir, plat_nomor, merk, jenis_kendaraan, waktu_masuk, status_parkir) VALUES ('$id_parkir', '$plat_nomor', '$merk', '$jenis_kendaraan', NOW(), '$status_parkir')");

    if ($result) {
        echo "<script>window.location.href='home.php';</script>";
    } else {
        echo "<script>alert('Data gagal ditambahkan!');</script>";
    }
}

$conn->close();
?>