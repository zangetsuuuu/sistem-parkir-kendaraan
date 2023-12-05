<?php
include "config/koneksi.php";

if (isset($_POST['update'])) {

    if (isset($_GET['id'])) {
        $username = $_POST['username'];
        $jenis_kelamin = $_POST['jenis_kelamin'];
        $no_telp = $_POST['no_telp'];
        $alamat = $_POST['alamat'];

        $result = mysqli_query($conn, "UPDATE operator SET username='$username', jenis_kelamin='$jenis_kelamin', no_telp='$no_telp', alamat='$alamat' WHERE id_operator = '$_GET[id]'");

        if ($result) {
            echo "<script>alert('Data berhasil diubah!');</script>";
            echo "<script>window.location.href='home_admin.php';</script>";
        } else {
            echo "<script>alert('Data gagal diubah!');</script>";
            echo "<script>window.location.href='home_admin.php';</script>";
        }
    }
}

$username = "";
$password = "";
$jenis_kelamin = "";
$no_telp = "";
$alamat = "";

if (isset($_GET['id'])) {

    $result = mysqli_query($conn, "SELECT * FROM operator WHERE id_operator = '$_GET[id]'");
    $row = mysqli_fetch_array($result);
        
    if ($row) {
        $username = $row['username'];
        $password = $row['password'];
        $jenis_kelamin = $row['jenis_kelamin'];
        $no_telp = $row['no_telp'];
        $alamat = $row['alamat'];
    } 
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Operator</title>
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
                        <span class="font-weight-bold">Ubah Data</span>
                    </div>
                    <div class="card-body">
                        <form method="post">
                            <div class="form-group">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" value="<?= $username ?>" class="form-control" placeholder="Masukkan Username">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" value="<?= $password ?>" class="form-control" placeholder="Masukkan Password">
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label class="form-label">Jenis Kelamin</label>
                                        <select name="jenis_kelamin" class="form-control">
                                            <option value="<?= $jenis_kelamin ?>"></option>
                                            <option value="Laki-laki">Laki-laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label class="form-label">No Telepon</label>
                                        <input type="text" name="no_telp" value="<?= $no_telp ?>" class="form-control" placeholder="Masukkan No Telepon">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Alamat</label>
                                <textarea name="alamat" value="<?= $alamat ?>" class="form-control" cols="30" rows="4" style="resize: none;" placeholder="Masukkan Alamat"></textarea>
                            </div>
                            <div>
                                <hr>
                                <button type="submit" name="update" class="btn btn-block btn-dark">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-5 mx-auto" style="max-width: 1000px;">
            <div class="card-body">
                <h5 class="card-title font-weight-bold">Data Operator</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Jenis Kelamin</th>
                            <th>No Telepon</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $no = 1;
                        $result = mysqli_query($conn, "SELECT * FROM operator order by id_operator asc");
                        while ($row = mysqli_fetch_array($result)) :
                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $row['username'] ?></td>
                                <td><?= $row['jenis_kelamin'] ?></td>
                                <td><?= $row['no_telp'] ?></td>
                                <td><?= $row['alamat'] ?></td>
                                <td>
                                    <a href="ubah.php?id=<?= $row['id_operator']; ?>" class="btn btn-block btn-dark">Ubah</a>
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
            window.location.href = "index.php";
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
