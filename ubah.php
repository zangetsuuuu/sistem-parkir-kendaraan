<?php
include "config/koneksi.php";

if (isset($_POST['update'])) {

    if (isset($_GET['id'])) {
        $username = $_POST['username'];
        $jenis_kelamin = $_POST['jenis_kelamin'];
        $no_telp = $_POST['no_telp'];
        $alamat = $_POST['alamat'];

        $result = mysqli_query($conn, "UPDATE operator SET username = '$username', jenis_kelamin = '$jenis_kelamin', no_telp = '$no_telp', alamat = '$alamat' WHERE id_operator = '$_GET[id]'");

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

$conn->close();
?> 

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/images/favicon.svg">
    <title>Ubah Data</title>

    <!-- Fontawesome  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/fontawesome.min.css"
        integrity="sha512-d0olNN35C6VLiulAobxYHZiXJmq+vl+BGIgAxQtD5+kqudro/xNMvv2yIHAciGHpExsIbKX3iLg+0B6d0k4+ZA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- Eksternal CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a404219d80.js" crossorigin="anonymous"></script>
</head>

<body style="background-color: #EEFCF6;">
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
        <div class="h2 text-center mb-3" style="margin-top: 120px;">Ubah Data</div>
        <p class="text-center text-secondary mb-4">Input data operator yang ingin diubah</p>

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

                <!-- Form Ubah -->
                <form method="POST" enctype="multipart/form-data" id="form-ubah" style="display: none;">
                    <div class="form-group mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control rounded-pill" name="username" placeholder="Masukkan Username" value="<?= $username ?>" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control rounded-pill" name="password" placeholder="Masukkan Password" value="<?= $password ?>" required>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-control rounded-pill" required>
                                    <option>Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki" <?= ($jenis_kelamin == 'Laki-laki') ? 'selected' : '' ?>>Laki-laki</option>
                                    <option value="Perempuan" <?= ($jenis_kelamin == 'Perempuan') ? 'selected' : '' ?>>Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group mb-3">
                                <label class="form-label">No Telepon</label>
                                <input type="text" name="no_telp" class="form-control rounded-pill"
                                    placeholder="Masukkan No Telepon" value="<?= $no_telp ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control rounded-4" cols="30" rows="3" style="resize: none;" placeholder="Masukkan Alamat" required><?= $alamat ?></textarea>
                    </div>
                    <div class="row">
                        <div class="col">
                            <a href="javascript:history.go(-1)" class="btn btn-secondary form-control rounded-pill px-4 me-2 mt-3"><i class="fa-solid fa-arrow-left me-2"></i>Back</a>
                        </div>
                        <div class="col-10">
                            <button type="submit" name="update" class="btn btn-primary form-control rounded-pill text-uppercase mt-3">Ubah</button>
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
        function showForm() {
            document.getElementById("loading").style.display = "none";
            document.getElementById("form-ubah").style.display = "block";
        }

        setTimeout(showForm, 200);
    </script>

    <!-- Bootstrap Javascript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>