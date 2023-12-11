<?php
include_once "config/koneksi.php";

if (isset($_POST["keluar"])) {
    $id_parkir = $_POST["id_parkir"];

    // Cek apakah kendaraan sudah keluar parkir
    $result = mysqli_query($conn, "SELECT status_parkir FROM parkir WHERE id_parkir = '$id_parkir'");
    if ($result) {
        $row = $result->fetch_assoc();
        if ($row['status_parkir'] == 'Keluar') {
            echo "<script>alert('Kendaraan sudah keluar parkir')</script>";
        } else {
            // Tambah waktu keluar
            $update_keluar = mysqli_query($conn, "UPDATE parkir SET waktu_keluar = NOW() WHERE id_parkir = '$id_parkir'");

            // Hitung biaya
            $waktu_masuk = strtotime($row['waktu_masuk']);
            $waktu_keluar = strtotime($row['waktu_keluar']);

            // Menghitung selisih waktu dalam jam
            $selisihJam = ($waktu_keluar - $waktu_masuk) / 3600;

            // Menghitung biaya parkir berdasarkan jenis kendaraan
            $biayaParkir = 0;
            $jenisKendaraan = $row['jenis_kendaraan'];
            if ($jenisKendaraan == 'Motor') {
                $biayaParkir = 2000 * $selisihJam;
            } elseif ($jenisKendaraan == 'Mobil') {
                $biayaParkir = 5000 * $selisihJam;
            } else {
                $biayaParkir = 7000 * $selisihJam;
            }

            include "biaya_parkir.php";
            $simpan = mysqli_query($conn, "UPDATE parkir SET biaya_parkir = '$biayaParkir' WHERE id_parkir = '$id_parkir'");
            if (!$simpan) {
                echo "Gagal menyimpan hasil biaya parkir ke dalam database.";
            }

            // Update status parkir menjadi 'Keluar'
            $update_status = mysqli_query($conn,"UPDATE parkir SET status_parkir = 'Keluar' WHERE id_parkir = '$id_parkir'");
        }
    } else {
        echo "ID Parkir tidak ditemukan.";
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keluar Parkir</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- Local CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a404219d80.js" crossorigin="anonymous"></script>
</head>

<body style="background-color: #F8FFFC;">
    <!-- Navbar -->
    <nav class="navbar fixed-top navbar-expand-lg py-3 shadow">
        <div class="container">
            <div class="navbar-brand d-inline-block align-text-top">
                <img src="assets/images/main-logo.svg" alt="Logo" width="30" height="30" class="me-2"
                    style="padding-bottom: 2px;">
                <span class="text-white font-weight-bold h5 me-2">SISTEM PARKIR KENDARAAN</span>
                <span style="font-size: 14px; color: #d4f8ea;">
                    <?php
                    date_default_timezone_set('Asia/Jakarta');
                    $hari = date('l');
                    $tanggal = date('d F Y');
                    echo $hari . ', ' . $tanggal;
                    ?>
                </span>
            </div>
            <div class="d-flex justify-content-end">
                <div class="navbar-brand">
                    <img src="assets/images/profile.svg" width="30" height="30" class="d-inline-block align-top" alt="">
                    <span class="text-white p-2">Admin</span>
                </div>
                <button type="submit" class="btn btn-outline rounded-pill navbar-brand text-white px-3"
                    style="margin-right: 0px;" onclick="logout()">Logout</button>
            </div>
        </div>
    </nav>

    <!-- Konten -->
    <div class="container">
        <!-- Title -->
        <div class="h2 text-center mb-3" style="margin-top: 120px;">Keluar Parkir</div>
        <p class="text-center text-secondary mb-4">Input ID parkir untuk menghitung biaya parkir</p>

        <!-- Tabel Daftar Operator -->
        <div class="card border-0 px-4 py-2 rounded-4 shadow-sm">
            <div class="card-body">
                <!-- Animasi loading -->
                <div id="loading">
                    <div class="d-flex align-items-center">
                        <strong>Loading...</strong>
                        <div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
                    </div>
                </div>

                <!-- Form Keluar -->
                <form method="POST" enctype="multipart/form-data" id="form-keluar" style="display: none;">
                    <div class="form-group mb-3">
                        <label class="form-label">ID Parkir</label>
                        <input type="text" class="form-control rounded-pill" name="id_parkir" placeholder="Masukkan ID Parkir" required>
                    </div>
                    <div class="row">
                        <div class="col">
                            <a href="home.php" class="btn btn-secondary form-control rounded-pill px-4 me-2 mt-3"><i class="fa-solid fa-arrow-left me-2"></i>Back</a>
                        </div>
                        <div class="col-10">
                            <button type="submit" name="keluar" class="btn btn-primary form-control rounded-pill text-uppercase mt-3">Konfirmasi</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Script Logout
        function logout() {
            event.preventDefault(); // Mencegah tindakan default dari link

            if (confirm("Apakah Anda Yakin Ingin Logout?")) {
                window.location.href = "index.php";
            }
        } 

        // Script loading
        function showTable() {
            document.getElementById("loading").style.display = "none";
            document.getElementById("form-keluar").style.display = "block";
        }

        setTimeout(showTable, 500);
    </script>

    <!-- Bootstrap Javascript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>