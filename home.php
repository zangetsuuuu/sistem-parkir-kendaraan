<?php
include "config/koneksi.php";

if (isset($_POST["keluar"])) {

    $result = mysqli_query($conn,"DELETE FROM parkir WHERE id_parkir = '$id_parkir'");
    
    if ($result) {
        echo "<script>alert('Data berhasil dihapus!');</script>";
        echo "<script>window.location.href='home.php';</script>";
    } else {
        echo "<script>alert('Data gagal diubah!');</script>";
        echo "<script>window.location.href='home.php';</script>";
    }  
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home Operator</title>
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
            <span class="p-2">Operator</span>
        </div>
        <a href="index.php" class="navbar-brand" onclick="logout()">
            <img src="assets/logout.svg" width="30" height="30" class="d-inline-block align-top" alt="">
            <span class="p-2">Logout</span>
        </a>
    </nav>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <span class="font-weight-bold">Tambah Data Parkir</span>
                    </div>
                    <div class="card-body">
                        <form action="tambah.php" method="POST">
                            <div class="form-group">
                                <label>Plat Nomor</label>
                                <input type="text" class="form-control" name="plat_nomor" placeholder="Masukkan Plat Nomor">
                            </div>
                            <div class="form-group">
                                <label>Merk</label>
                                <input type="text" class="form-control" name="merk" placeholder="Masukkan Nama Merk">
                            </div>
                            <div class="form-group">
                                <label>Jenis Kendaraan</label>
                                <select name="jenis_kendaraan" class="form-control">
                                    <option>Pilih Jenis Kendaraan</option>
                                    <option value="Motor">Motor</option>
                                    <option value="Mobil">Mobil</option>
                                    <option value="Truk/Bis/Lainnya">Truk/Bis/Lainnya</option>
                                </select>
                            </div>
                            <div>
                                <hr>
                                <button type="submit" name="tambah_parkir" class="btn btn-block btn-primary">Tambah Parkir</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
            <div class="card">
                    <div class="card-header">
                        <span class="font-weight-bold">Keluar Parkir</span>
                    </div>
                    <div class="card-body">
                        <form action="home.php" method="POST">
                            <div class="form-group">
                                <label>ID Parkir</label>
                                <input type="text" class="form-control" name="id_parkir" placeholder="Masukkan ID Parkir">
                            </div>
                            <div>
                                <hr>
                                <button type="submit" name="keluar" class="btn btn-block btn-primary">Keluar Parkir</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mx-auto mt-5">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h5 class="card-title font-weight-bold">Daftar Parkir</h5>
                        <button class="btn btn-primary" onclick="window.print()">Cetak Laporan</button>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Parkir</th>
                            <th>Plat Nomor</th>
                            <th>Merk</th>
                            <th>Jenis Kendaraan</th>
                            <th>Waktu Masuk</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $result = mysqli_query($conn, "SELECT * FROM parkir");
                        while ($row = mysqli_fetch_array($result)) :
                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $row['id_parkir'] ?></td>
                                <td><?= $row['plat_nomor'] ?></td>
                                <td><?= $row['merk'] ?></td>
                                <td><?= $row['jenis_kendaraan'] ?></td>
                                <td><?= date('d F Y, H:i:s', strtotime($row['waktu_masuk'])) ?> WIB</td>
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