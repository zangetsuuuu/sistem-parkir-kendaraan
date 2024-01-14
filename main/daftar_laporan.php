<?php
include "config/koneksi.php";
include "login.php";
include "login_session.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/images/favicon.svg">
    <title>Halaman Admin</title>
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

    <!-- Eksternal CSS -->
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
            <div class="d-flex justify-content-end">
                <button id="btn-ya" class="btn btn-primary rounded-pill px-4 me-2">Ya</button>
                <button id="btn-tidak" class="btn btn-secondary rounded-pill px-4">Tidak</button>
            </div>
        </div>
    </div>

    <!-- Konten -->
    <div class="container">
        <!-- Title -->
        <div class="h2 text-center mb-3" style="margin-top: 120px;">Daftar Laporan</div>
        <p class="text-center text-secondary fs-6 mb-4">Selamat datang, <span class="text-capitalize"><?= $_SESSION["username"]; ?></span></p>

        <!-- Menu Back -->
        <div class="card mb-3 border-0 px-4 py-2 rounded-4 shadow-sm">
            <div class="card-body">
                <a href="home_admin.php"><button class="btn btn-primary rounded-pill px-4 py-2 me-2"><i class="fa-solid fa-user me-2"></i>Daftar Operator</button></a>
            </div>
        </div>

        <!-- Tabel Daftar Operator -->
        <div class="card border-0 px-4 py-2 rounded-4 shadow-sm mb-5">
            <div class="card-body">
                <!-- Jumlah operator dan hasil Pencarian -->
                <?php
                $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM laporan");
                $row = mysqli_fetch_assoc($result);
                $totalLaporan = $row['total'];
                ?>
                <div class="d-flex d-flex justify-content-between">
                    <?php
                    if (isset($_GET['keyword'])) {
                        $keyword = $_GET['keyword'];
                        echo "<div id=\"table-info\" style=\"display: none; margin-top: 12px;\" class=\"fs-6\">Hasil Pencarian: $keyword</div>";
                    } else {
                        echo "<div id=\"table-info\" style=\"display: none; margin-top: 12px;\" class=\"fs-6\">Menampilkan $totalLaporan Data Laporan</div>";
                    }
                    ?>                    

                    <!-- Search box -->
                    <form method="GET" class="mb-4" id="table-cari" style="display: none;">
                        <div class="input-group">
                            <input type="text" class="form-control rounded-pill me-2" name="keyword" placeholder="Cari ID Laporan...">
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

                <!-- Tabel daftar operator -->
                <table class="table table-bordered table-striped table-hover text-center" style="display: none; border-radius: 40px;" id="table-data">
                    <thead>
                        <tr>
                            <th class="py-3">No</th>
                            <th class="py-3">ID Laporan</th>
                            <th class="py-3">Operator</th>
                            <th class="py-3">Jenis Laporan</th>
                            <th class="py-3">Tanggal Dibuat</th>
                            <th class="py-3">Keterangan</th>
                            <th class="py-3 px-3">File</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($_GET['keyword'])) {
                            $keyword = $_GET['keyword'];
                            $query = "SELECT * FROM laporan WHERE id_laporan LIKE '%$keyword%'";
                            $result = mysqli_query($conn, $query);
                        } else {
                            $result = mysqli_query($conn, "SELECT * FROM laporan ORDER BY tanggal_dibuat DESC");
                        }

                        $no = 1;

                        // Memeriksa jumlah baris yang dikembalikan
                        $row_count = mysqli_num_rows($result);
                        
                        if ($row_count > 1) {
                            // Looping untuk menampilkan data operator
                            while ($row = mysqli_fetch_array($result)) :
                        ?>
                            <tr>
                                <td class="py-3"><?= $no++ ?></td>
                                <td class="py-3"><?= $row['id_laporan'] ?></td>
                                <td class="py-3"><?= $row['username_operator'] ?></td>
                                <td class="py-3"><?= $row['jenis_laporan'] ?></td>
                                <td class="py-3"><?= date('d-m-Y, H:i:s', strtotime($row['tanggal_dibuat'])) ?> WIB</td>
                                <td class="py-3"><?= $row['keterangan'] ?></td>
                                <td class="py-3">
                                    <a href="laporan/laporan_<?= $row['id_laporan'] ?>.pdf" target="_blank">
                                        <i class="fa-solid fa-lg fa-file-pdf text-danger"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php
                            endwhile;
                        } else {
                            echo '<tr><td colspan="7" class="text-center">Tidak ada data</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
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

        function showTable() {
            document.getElementById("loading").style.display = "none";
            document.getElementById("table-data").style.display = "table";
            document.getElementById("table-info").style.display = "block";
            document.getElementById("table-cari").style.display = "block";
        }

        setTimeout(showTable, 500);

        // Form tambah operator
        function formTambahOperator() {
            var modal = document.getElementById('tambahOperator');
            modal.style.display = 'block';
        }

        function closeOperator() {
            var modal = document.getElementById('tambahOperator');
            modal.style.display = 'none';
        }
    </script>

    <!-- Bootstrap Javascript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>