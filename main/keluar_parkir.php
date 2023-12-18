<?php
include "config/koneksi.php";

if (isset($_POST["keluar"])) {
    $id_parkir = $_POST["id_parkir"];

    // Tambahkan kondisi untuk menampilkan pesan jika status_parkir sudah 'Keluar'
    $cek_status = mysqli_query($conn, "SELECT status_parkir FROM parkir WHERE id_parkir = '$id_parkir'");
    $result_status = mysqli_fetch_assoc($cek_status);
    if ($result_status['status_parkir'] == 'Keluar') {
        echo "<script>alert('Kendaraan sudah keluar parkir')</script>";
        echo "<script>window.location.href='home.php'</script>";
        exit;
    }

    // Tambah waktu keluar
    $update_keluar = mysqli_query($conn, "UPDATE parkir SET waktu_keluar = NOW() WHERE id_parkir = '$id_parkir'");

    // Hitung biaya
    $result = mysqli_query($conn, "SELECT * FROM parkir WHERE id_parkir = '$id_parkir'");

    if ($result) {
        $row = $result->fetch_assoc();
        $waktu_masuk = strtotime($row['waktu_masuk']);
        $waktu_keluar = strtotime($row['waktu_keluar']);

        // Menghitung biaya parkir berdasarkan jenis kendaraan
        $biayaParkir = 0;
        $jenisKendaraan = $row['jenis_kendaraan'];
        if ($jenisKendaraan == 'Motor') {
            $biayaAwal = 2000;
        } elseif ($jenisKendaraan == 'Mobil') {
            $biayaAwal = 3000;
        } else {
            $biayaAwal = 5000;
        }

        $selisihJam = ceil(($waktu_keluar - $waktu_masuk) / 3600); // Pembulatan ke atas jumlah jam

        if ($selisihJam <= 1) {
            $biayaParkir = $biayaAwal;
        } else {
            $biayaParkir = $biayaAwal + ($biayaAwal * ($selisihJam - 1));
        }

        $simpan = mysqli_query($conn, "UPDATE parkir SET biaya_parkir = '$biayaParkir' WHERE id_parkir = '$id_parkir'");
        if (!$simpan) {
            echo "Gagal menyimpan hasil biaya parkir ke dalam database.";
        }
    } else {
        echo "<script>alert('ID Parkir tidak ditemukan')</script>";
    }

    // Update status parkir menjadi 'Keluar'
    $update_status = mysqli_query($conn, "UPDATE parkir SET status_parkir = 'Keluar' WHERE id_parkir = '$id_parkir'");
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/images/favicon.svg">
    <title>Biaya Parkir</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- Eksternal CSS -->
    <link rel="stylesheet" href="assets/css/styles.css">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a404219d80.js" crossorigin="anonymous"></script>
</head>

<body style="background-color: #fff;">
    <div class="container d-flex justify-content-center">
        <div class="card p-3 shadow" style="width: 300px; margin: 200px auto;">
            <div class="card-body">
                <h3 class="card-title text-center">Biaya Parkir</h3>
                <hr>
                <div class="card-text">
                    <div class="text-center fs-5 mt-4">
                        RP. <?= number_format(round($biayaParkir), 0, ',', '.'); ?>
                    </div>
                    <a href="home.php" class="btn btn-primary mt-4" style="width: 100%;"><i class="fa-solid fa-check fa-lg" style="color: #ffffff;"></i></a>
                </div>
            </div>
        </div>
</body>

</html>