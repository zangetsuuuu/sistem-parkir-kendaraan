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

    $plat_nomor = $_POST['plat_nomor'];
    $merk = $_POST['merk'];
    $jenis_kendaraan = $_POST['jenis_kendaraan'];
    $status_parkir = "Sedang Parkir";
    
    // Masukkan data ke dalam tabel kendaraan
    $result_kendaraan = mysqli_query($conn, "INSERT INTO kendaraan (plat_nomor, merk, jenis_kendaraan) VALUES ('$plat_nomor', '$merk', '$jenis_kendaraan')");
    
    if ($result_kendaraan) {
        // Mengambil id_kendaraan
        $id_kendaraan = mysqli_insert_id($conn);   
        $id_parkir = "IP" . rand(100, 999);
    
        $result_parkir = mysqli_query($conn, "INSERT INTO parkir (id_parkir, id_kendaraan, plat_nomor, merk, jenis_kendaraan, waktu_masuk, status_parkir) VALUES ('$id_parkir', '$id_kendaraan', '$plat_nomor', '$merk', '$jenis_kendaraan', NOW(), '$status_parkir')");
    
        if ($result_parkir) {
            echo "<script>window.location.href='home.php';</script>";
        } else {
            echo "<script>alert('Data gagal ditambahkan!');</script>";
            echo "<script>window.location.href='home_admin.php';</script>";
        }
    }
}

$conn->close();
?>