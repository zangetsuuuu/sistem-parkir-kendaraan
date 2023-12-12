<?php
include "config/koneksi.php";
include "login.php";

$conn->close()
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/images/favicon.svg">
    <title>Halaman Login</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- Local CSS -->
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
                <span class="text-white font-weight-bold h5">SISTEM PARKIR KENDARAAN</span>
            </div>
            <span class="navbar-text text-white">
                <?php
                date_default_timezone_set('Asia/Jakarta');
                $hari = date('l');
                $tanggal = date('d F Y');
                echo $hari . ', ' . $tanggal;
                ?>
            </span>
        </div>
    </nav>

    <!-- Form Login -->
    <div class="container">
        <div class="card mx-auto rounded-4 shadow" style="max-width: 500px; margin-top: 160px;">
            <div class="card-body p-5">
                <div class="card-title h2 text-center mb-3">Login</div>
                <p class="card-text text-center text-secondary mb-4" style="font-size: 14px;">Silahkan Isi Username dan Password!</p>
                <hr>
                <form method="POST" enctype="multipart/form-data">
                    <div class="text-center mt-4 mb-3">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input rounded-pill" type="checkbox" name="operator"
                                value="Operator" onclick="uncheckOther(this, 'admin')">
                            <label class="form-check-label">Operator</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input rounded-pill" type="checkbox" name="admin" value="Admin"
                                onclick="uncheckOther(this, 'operator')">
                            <label class="form-check-label">Admin</label>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control rounded-pill" name="username" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control rounded-pill" name="password" required>
                    </div>
                    <button type="submit" name="login"
                        class="btn btn-primary form-control rounded-pill text-uppercase mt-3">Login</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Checkbox Script -->
    <script>
        function uncheckOther(checkbox, other) {
            var checkboxes = document.getElementsByName(other);
            checkboxes.forEach(function (cb) {
                if (cb !== checkbox) {
                    cb.checked = false;
                }
            });
        }
    </script>

    <!-- Bootstrap Javascript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>