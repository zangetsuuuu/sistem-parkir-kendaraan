<?php
include "config/koneksi.php";
include "login.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/images/favicon.svg">
    <title>Cari Kendaraan</title>
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fff;
            margin: 50px auto;
            padding: 40px;
            border: 1px solid #888;
            max-width: 1000px;
            width: 80%;
            border-radius: 10px;
        }
    </style>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- Local CSS -->
    <link rel="stylesheet" href="assets/css/styles.css">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a404219d80.js" crossorigin="anonymous"></script>    
</head>

<body>
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
                    style="margin-right: 0px;" onclick="logout()"><i class="fa-solid fa-arrow-right-from-bracket me-2"></i>Logout</button>
            </div>
        </div>
    </nav>

    <!-- Konfirmasi logout -->
    <div class="modal" id="logout">
        <div class="modal-content">
            <div class="h3">Konfirmasi</div><hr style="margin-top: 0px; margin-bottom: 30px;">
            <div class="fs-5 mb-4">Apakah anda yakin ingin logout? </div>
            <div class="d-flex justify-content-start">
                <button id="btn-ya" class="btn btn-primary rounded-pill px-4 me-2">Ya</button>
                <button id="btn-tidak" class="btn btn-secondary rounded-pill px-4">Tidak</button>
            </div>
        </div>
    </div>

    <!-- Konten -->
    <div class="container">
        <!-- Title -->
        <div class="h2 text-center mb-3" style="margin-top: 120px;">Daftar Parkir Kendaraan</div>
        <p class="text-center text-secondary mb-4">Cari data berdasarkan ID parkir dan plat nomor</p>

        <!-- Menu Tambah Data -->
        <div class="card mb-3 border-0 px-4 py-2 rounded-4 shadow-sm">
            <div class="card-body">
                <a href="javascript:history.go(-1)" class="btn btn-secondary rounded-pill px-4 py-2 me-2"><i class="fa-solid fa-arrow-left me-2"></i>Back</a>
            </div>
        </div>

        <!-- Tabel Daftar Operator -->
        <div class="card border-0 px-4 py-2 rounded-4 shadow-sm">
            <div class="card-body">
                
                <!-- Info Tabel -->
                <div class="d-flex d-flex justify-content-between">
                    <?php $keyword = $_GET['keyword']; ?>
                    <div id="table-info" style="display: none; margin-top: 12px;">Hasil Pencarian: <?= $keyword ?></div>

                    <form method="GET" action="cari_parkir.php" class="mb-4" id="table-cari" style="display: none;">
                        <div class="input-group">
                            <input type="text" class="form-control rounded-pill me-2" name="keyword" placeholder="Cari operator...">
                            <button type="submit" class="btn btn-primary rounded-pill px-4"><i class="fa-solid fa-magnifying-glass me-2"></i>Cari</button>
                        </div>
                    </form>
                </div>

                <!-- Animasi loading -->
                <div id="loading">
                    <div class="d-flex align-items-center">
                        <strong>Loading...</strong>
                        <div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
                    </div>
                </div>

                <table class="table table-bordered table-striped table-hover text-center" style="display: none; border-radius: 40px;" id="table-data">
                    <thead>
                        <tr>
                            <th class="py-3">No</th>
                            <th class="py-3">ID Parkir</th>
                            <th class="py-3">Plat Nomor</th>
                            <th class="py-3">Jenis Kendaraan</th>
                            <th class="py-3">Merk</th>
                            <th class="py-3">Waktu Masuk</th>
                            <th class="py-3">Waktu Keluar</th>
                            <th class="py-3">Status Parkir</th>
                            <th class="py-3">Cetak</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $keyword = $_GET['keyword'];
                        $query = "SELECT * FROM parkir WHERE id_parkir LIKE '%$keyword%' OR plat_nomor LIKE '%$keyword%'";
                        $result = mysqli_query($conn, $query);
                        

                        $no = 1;
                        while ($row = mysqli_fetch_array($result)) :
                        ?>
                            <tr>
                                <td class="py-3"><?= $no++ ?></td>
                                <td class="py-3"><?= $row['id_parkir'] ?></td>
                                <td class="py-3"><?= $row['plat_nomor'] ?></td>
                                <td class="py-3"><?= $row['merk'] ?></td>
                                <td class="py-3"><?= $row['jenis_kendaraan'] ?></td>
                                <td class="py-3"><?= date('d-m-Y, H:i:s', strtotime($row['waktu_masuk'])) ?> WIB</td>
                                <td class="py-3"><?= date('d-m-Y, H:i:s', strtotime($row['waktu_keluar'])) ?> WIB</td>
                                <td class="py-3"><?= $row['status_parkir'] ?></td>
                                <td class="py-3"><a href="cetak.php?id=<?= $row['id_parkir'] ?>"><i class="fa-solid fa-print" style="color: #26C485;"></i></a></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Script logout
        function logout() {
            var modal = document.getElementById('logout');
            modal.style.display = 'block';

            var yes = document.getElementById('btn-ya');
            var no = document.getElementById('btn-tidak');

            yes.addEventListener('click', function() {
                window.location.href = 'logout.php';
            });

            no.addEventListener('click', function() {
                modal.style.display = 'none';
            });
        } 

        // Script Loading
        function showTable() {
            document.getElementById("loading").style.display = "none";
            document.getElementById("table-data").style.display = "table";
            document.getElementById("table-info").style.display = "block";
            document.getElementById("table-cari").style.display = "block";
        }

        setTimeout(showTable, 500);
    </script>

    <!-- Bootstrap Javascript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>