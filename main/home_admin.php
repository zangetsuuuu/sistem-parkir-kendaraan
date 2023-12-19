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
        <div class="h2 text-center mb-3" style="margin-top: 120px;">Daftar Operator</div>
        <p class="text-center text-secondary fs-6 mb-4">Selamat datang, <span class="text-capitalize"><?= $_SESSION["username"]; ?></span></p>

        <!-- Menu Tambah Data dan Back -->
        <div class="card mb-3 border-0 px-4 py-2 rounded-4 shadow-sm">
            <div class="card-body">
                <button onclick="formTambahOperator()" class="btn btn-primary rounded-pill px-4 py-2"><i class="fa-solid fa-plus me-2"></i>Tambah Operator</button>
            </div>
        </div>

        <!-- Form Tambah Operator -->
        <div id="tambahOperator" class="modal">
            <div class="modal-content">
                <div class="h3">Tambah Operator</div><hr style="margin-top: 0px; margin-bottom: 30px;">
                <form action="tambah.php" method="POST" enctype="multipart/form-data" id="form-tambah-operator">
                    <div class="row g-3">
                        <div class="col">
                            <div class="form-group mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control rounded-pill" name="username"
                                    placeholder="Masukkan Username" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group mb-3">
                                <label class="form-label">Email</label>
                                <input type="text" class="form-control rounded-pill" name="email"
                                    placeholder="Masukkan Email" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control rounded-pill" name="password"
                            placeholder="Masukkan Password" required>
                    </div>
                    <div class="row g-3">
                        <div class="col">
                            <div class="form-group mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-select rounded-pill" required>
                                    <option>Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group mb-3">
                                <label class="form-label">No Telepon</label>
                                <input type="text" class="form-control rounded-pill" name="no_telp"
                                    placeholder="Masukkan No Telepon" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control rounded-4" cols="30" rows="3" style="resize: none;" placeholder="Masukkan Alamat" required></textarea>
                    </div>
                    <div class="row g-3">
                        <div class="col">
                            <button type="button" class="btn btn-secondary form-control rounded-pill px-4 me-2 mt-3"
                                onclick="closeOperator()">
                                Batal
                            </button>
                        </div>
                        <div class="col-10">
                            <button type="submit" name="tambah"
                                class="btn btn-primary form-control rounded-pill text-uppercase mt-3">
                                Tambah
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabel Daftar Operator -->
        <div class="card border-0 px-4 py-2 rounded-4 shadow-sm">
            <div class="card-body">
                <!-- Jumlah operator dan hasil Pencarian -->
                <?php
                $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM operator");
                $row = mysqli_fetch_assoc($result);
                $totalOperator = $row['total'];
                ?>
                <div class="d-flex d-flex justify-content-between">
                    <?php
                    if (isset($_GET['keyword'])) {
                        $keyword = $_GET['keyword'];
                        echo "<div id=\"table-info\" style=\"display: none; margin-top: 12px;\" class=\"fs-6\">Hasil Pencarian: $keyword</div>";
                    } else {
                        echo "<div id=\"table-info\" style=\"display: none; margin-top: 12px;\" class=\"fs-6\">Menampilkan $totalOperator Data Operator</div>";
                    }
                    ?>                    

                    <!-- Search box -->
                    <form method="GET" class="mb-4" id="table-cari" style="display: none;">
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
                            <th class="py-3">Email</th>
                            <th class="py-3">Jenis Kelamin</th>
                            <th class="py-3">No Telepon</th>
                            <th class="py-3">Alamat</th>
                            <th class="py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($_GET['keyword'])) {
                            $keyword = $_GET['keyword'];
                            $query = "SELECT * FROM operator WHERE username LIKE '%$keyword%'";
                            $result = mysqli_query($conn, $query);
                        } else {
                            $result = mysqli_query($conn, "SELECT * FROM operator ORDER BY id_operator ASC");
                        }

                        $no = 1;
                        // Looping untuk menampilkan data operator
                        while ($row = mysqli_fetch_array($result)) :
                        ?>
                            <tr>
                                <td class="py-3"><?= $no++ ?></td>
                                <td class="py-3"><?= $row['username'] ?></td>
                                <td class="py-3"><?= $row['email'] ?></td>
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