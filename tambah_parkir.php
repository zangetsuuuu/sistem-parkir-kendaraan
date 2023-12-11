<?php
include "config/koneksi.php";

if (isset($_POST['tambah_parkir'])) {
    date_default_timezone_set('Asia/Jakarta');

    $id_parkir = "IP" . rand(100, 999);
    $plat_nomor = $_POST['plat_nomor'];
    $merk = $_POST['merk'];
    $jenis_kendaraan = $_POST['jenis_kendaraan'];
    $status_parkir = "Sedang Parkir";

    $result = mysqli_query($conn, "INSERT INTO parkir (id_parkir, plat_nomor, merk, jenis_kendaraan, waktu_masuk, status_parkir) VALUES ('$id_parkir', '$plat_nomor', '$merk', '$jenis_kendaraan', NOW(), '$status_parkir')");

    if ($result) {
        echo "<script>alert('Data berhasil ditambahkan!');</script>";
        echo "<script>window.location.href='home.php';</script>";
    } else {
        echo "<script>alert('Data gagal ditambahkan!');</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>

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
        <div class="h2 text-center mb-3" style="margin-top: 120px;">Tambah Data</div>
        <p class="text-center text-secondary mb-4">Input data parkir baru</p>

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

                <!-- Form Tambah Parkir -->
                <form method="POST" enctype="multipart/form-data" id="form-tambah" style="display: none;">
                    <div class="form-group mb-3">
                        <label class="form-label">Plat Nomor</label>
                        <input type="text" class="form-control rounded-pill" name="plat_nomor"
                            placeholder="Masukkan Plat Nomor" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Jenis Kendaraan</label>
                        <select name="jenis_kendaraan" class="form-control rounded-pill" required>
                            <option>Pilih Jenis Kendaraan</option>
                            <option value="Motor">Motor</option>
                            <option value="Mobil">Mobil</option>
                            <option value="Bis/Truk/Lainnya">Bis/Truk/Lainnya</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Merk</label>
                        <input type="text" class="form-control rounded-pill" name="merk"
                            placeholder="Masukkan Merk Kendaraan" required>
                    </div>
                    <div class="row">
                        <div class="col">
                            <a href="javascript:history.go(-1)"
                                class="btn btn-secondary form-control rounded-pill px-4 me-2 mt-3"><i
                                    class="fa-solid fa-arrow-left me-2"></i>Back</a>
                        </div>
                        <div class="col-10">
                            <button type="submit" name="tambah_parkir"
                                class="btn btn-primary form-control rounded-pill text-uppercase mt-3"
                                >Tambah Parkir</button>
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
            document.getElementById("form-tambah").style.display = "block";
        }

        setTimeout(showTable, 500);
    </script>

    <!-- Bootstrap Javascript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>