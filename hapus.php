<?php include_once "config/koneksi.php";

if (isset($_GET['id'])) {

    $result = mysqli_query($conn, "DELETE FROM operator WHERE id_operator = '$_GET[id]' ");
        
    if ($result) {
        echo "<script>
            var konfirmasi = confirm('Apakah Anda yakin ingin menghapus data ini?');
            if (konfirmasi) {
                window.location.href = 'hapus.php?id=' + $id;
            }
          </script>";
        echo "<script>window.location.href='home_admin.php';</script>";
    } else {
        echo "<script>alert('Data gagal diubah!');</script>";
        echo "<script>window.location.href='home_admin.php';</script>";
    }  
}

elseif (isset($_GET["keluar"])) {

    $result = mysqli_query($conn,"DELETE FROM parkir WHERE id_parkir = $id_parkir");
    
    if ($result) {
        echo "<script>alert('Data berhasil dihapus!');</script>";
        echo "<script>window.location.href='home_admin.php';</script>";
    } else {
        echo "<script>alert('Data gagal diubah!');</script>";
        echo "<script>window.location.href='home_admin.php';</script>";
    }  
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Operator</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Albert+Sans:wght@400;500;600&display=swap');

        body {
            font-family: "Albert Sans", sans-serif;
        }

        nav,
        .card {
            box-shadow: 0 6px 8px 0 rgba(0, 0, 0, 0.2);
        }
    </style>
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
        <div class="card mx-auto" style="max-width: 1000px;">
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
                                    <a href="hapus.php?id=<?= $row['id_operator']; ?>" class="btn btn-block btn-dark">Hapus</a>
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
