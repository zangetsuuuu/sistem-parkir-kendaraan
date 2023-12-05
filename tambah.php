<?php
include "config/koneksi.php";

if (isset($_POST['tambah'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $no_telp = $_POST['no_telp'];
    $alamat = $_POST['alamat'];

    $result = mysqli_query($conn, "INSERT INTO operator (username, password, jenis_kelamin, no_telp, alamat) VALUES ('$username', '$password', '$jenis_kelamin', '$no_telp', '$alamat')");

    if ($result) {
        echo "<script>alert('Data berhasil ditambahkan!');</script>";
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

    $result = mysqli_query($conn, "INSERT INTO parkir (id_parkir, plat_nomor, merk, jenis_kendaraan, waktu_masuk) VALUES ('$id_parkir', '$plat_nomor', '$merk', '$jenis_kendaraan', NOW())");

    if ($result) {
        echo "<script>alert('Data berhasil ditambahkan!');</script>";
        echo "<script>window.location.href='home.php';</script>";
    } else {
        echo "<script>alert('Data gagal ditambahkan!');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="config/style.css">
</head>
<body>
    <nav class="navbar navbar-light bg-light p-3 mb-4">
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
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <span class="font-weight-bold">Tambah Data</span>
                    </div>
                    <div class="card-body">
                        <form action="tambah.php" method="post">
                            <div class="form-group">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" placeholder="Masukkan Username">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Masukkan Password">
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label class="form-label">Jenis Kelamin</label>
                                        <select name="jenis_kelamin" class="form-control">
                                            <option>Pilih Jenis Kelamin</option>
                                            <option value="Laki-laki">Laki-laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label class="form-label">No Telepon</label>
                                        <input type="text" name="no_telp" class="form-control" placeholder="Masukkan No Telepon">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Alamat</label>
                                <textarea name="alamat" class="form-control" cols="30" rows="4" style="resize: none;" placeholder="Masukkan Alamat"></textarea>
                            </div>
                            <div>
                                <hr>
                                <button type="submit" name="tambah" class="btn btn-block btn-dark">Tambah</button>
                            </div>
                        </form>
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
