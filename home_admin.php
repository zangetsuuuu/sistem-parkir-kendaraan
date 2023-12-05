<?php
include "config/koneksi.php";

?>

<!DOCTYPE html>
<html>
<head>
    <title>Home Admin</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="config/style.css">
</head>
<body>
    <nav class="navbar navbar-light bg-light p-3 mb-5">
        <div class="navbar-brand">
            <img src="https://cdns.iconmonstr.com/wp-content/releases/preview/2016/240/iconmonstr-car-21.png" width="30" height="30" class="d-inline-block align-top" alt="">
            <span class="font-weight-bold" style="letter-spacing: 0.5px;">SISTEM PARKIR KENDARAAN</span>
        </div>
        <span class="navbar-text mx-auto">
            <?php
            date_default_timezone_set('Asia/Jakarta');
            $hari = date('l');
            $tanggal = date('d F Y');
            echo $hari . ', ' . $tanggal;
            ?>
        </span>
        <div class="navbar-brand">
            <img src="assets/person.svg" width="30" height="30" class="d-inline-block align-top" alt="">
            <span class="p-2">Admin</span>
        </div>
        <a href="index.php" class="navbar-brand" onclick="logout()">
            <img src="assets/logout.svg" width="30" height="30" class="d-inline-block align-top" alt="">
            <span class="p-2">Logout</span>
        </a>
    </nav>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-3">
                <div class="card mt-5">
                    <img src="assets/create.svg" class="card-img-top border-bottom border-dark" alt="">
                    <div class="card-body">
                        <h5 class="card-title">Create</h5>
                        <p class="card-text">Tambah data operator.</p>
                        <a href="tambah.php" class="btn btn-block btn-dark">Tambah</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card mt-5">
                    <img src="assets/read.svg" class="card-img-top border-bottom border-dark" alt="">
                    <div class="card-body">
                        <h5 class="card-title">Read</h5>
                        <p class="card-text">Lihat data operator.</p>
                        <a href="lihat.php" class="btn btn-block btn-dark">Lihat</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card mt-5">
                    <img src="assets/update.svg" class="card-img-top border-bottom border-dark" alt="">
                    <div class="card-body">
                        <h5 class="card-title">Update</h5>
                        <p class="card-text">Ubah data operator.</p>
                        <a href="ubah.php" class="btn btn-block btn-dark">Ubah</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card mt-5">
                    <img src="assets/delete.svg" class="card-img-top border-bottom border-dark" alt="">
                    <div class="card-body">
                        <h5 class="card-title">Delete</h5>
                        <p class="card-text">Hapus data operator.</p>
                        <a href="hapus.php" class="btn btn-block btn-dark">Hapus</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function logout() {
            window.location.href = "index.php";
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>