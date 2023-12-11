<?php
include "config/koneksi.php";
include "login.php";
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

    <!-- Eksternal CSS -->
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
                    style="margin-right: 0px;" onclick="logout()"><i class="fa-solid fa-arrow-right-from-bracket me-2"></i>Logout</button>
            </div>
        </div>
    </nav>

    <!-- Konten -->
    <div class="container">
        <!-- Title -->
        <div class="h2 text-center mb-3" style="margin-top: 120px;">Daftar Operator</div>
        <p class="text-center text-secondary mb-4">Selamat datang, <span class="text-capitalize"><?= $_SESSION["username"]; ?></span></p>

        <!-- Menu Tambah Data dan Back -->
        <div class="card mb-3 border-0 px-4 py-2 rounded-4 shadow-sm">
            <div class="card-body">
                <a href="tambah.php" class="btn btn-primary rounded-pill px-4 py-2"><i class="fa-solid fa-plus me-2"></i>Tambah Data</a>
            </div>
        </div>

        <!-- Tabel Daftar Operator -->
        <div class="card border-0 px-4 py-2 rounded-4 shadow-sm">
            <div class="card-body">
                <!-- Jumlah operator -->
                <?php
                $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM operator");
                $row = mysqli_fetch_assoc($result);
                $totalOperator = $row['total'];
                ?>
                <div class="d-flex d-flex justify-content-between">
                    <div id="table-info" style="display: none; margin-top: 12px;">Menampilkan <?= $totalOperator ?> Data Operator</div>

                    <!-- Search box -->
                    <form method="GET" action="cari.php" class="mb-4" id="table-cari" style="display: none;">
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

                <!-- Tabel daftar operator -->
                <table class="table table-bordered table-striped table-hover text-center" style="display: none; border-radius: 40px;" id="table-data">
                    <thead>
                        <tr>
                            <th class="py-3">No</th>
                            <th class="py-3">Username</th>
                            <th class="py-3">Jenis Kelamin</th>
                            <th class="py-3">No Telepon</th>
                            <th class="py-3">Alamat</th>
                            <th class="py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $result = mysqli_query($conn, "SELECT * FROM operator ORDER BY id_operator ASC");

                        // Looping untuk menampilkan data operator
                        while ($row = mysqli_fetch_array($result)) :
                        ?>
                            <tr>
                                <td class="py-3"><?= $no++ ?></td>
                                <td class="py-3"><?= $row['username'] ?></td>
                                <td class="py-3"><?= $row['jenis_kelamin'] ?></td>
                                <td class="py-3"><?= $row['no_telp'] ?></td>
                                <td class="py-3"><?= $row['alamat'] ?></td>
                                <td class="py-3">
                                    <a href="ubah.php?id=<?= $row['id_operator']; ?>"><i class="fa-solid fa-pen fa-lg fa-fade me-2"></i></a>
                                    <a href="hapus.php?id=<?= $row['id_operator']; ?>"><i class="fa-solid fa-trash fa-lg fa-fade ms-2"></i></a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function logout() {
            event.preventDefault(); // Mencegah tindakan default dari link

            if (confirm("Apakah Anda Yakin Ingin Logout?")) {
                window.location.href = "index.php";
            }
        } 

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