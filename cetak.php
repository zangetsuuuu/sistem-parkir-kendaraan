<?php
include_once "config/koneksi.php";

if (isset($_GET['id'])) {
    $result = mysqli_query($conn, "SELECT * FROM parkir WHERE id_parkir = '$_GET[id]'");
    $row = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/images/favicon.svg">
    <title>Cetak Karcis</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- Eksternal CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a404219d80.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container d-flex justify-content-center">
        <div class="card p-3 shadow" style="width: 450px; margin: 160px auto;">
            <div class="card-body">
                <h3 class="card-title text-center">Karcis Parkir</h3><hr>
                <div class="card-text mt-4 d-flex justify-content-between">
                    <span><i class="fa-solid fa-hashtag me-2"></i>ID Parkir:</span>
                    <span><?= $row['id_parkir']; ?></span>
                </div>
                <div class="card-text mt-4 d-flex justify-content-between">
                    <span><i class="fa-solid fa-angles-right me-2"></i>Plat Nomor:</span>
                    <span><?= $row['plat_nomor']; ?></span>
                </div>
                <div class="card-text mt-4 d-flex justify-content-between">
                    <span><i class="fa-solid fa-clock me-2"></i>Waktu Masuk:</span>
                    <span><?= date('d-m-Y, H:i:s', strtotime($row['waktu_masuk'])) ?> WIB</span>
                </div>
                <div class="card-text mt-4 d-flex justify-content-between">
                    <span><i class="fa-solid fa-car me-2"></i></i>Jenis Kendaraan:</span>
                    <span><?= $row['jenis_kendaraan']; ?></span>
                </div>
                <div class="card-text mt-4 d-flex justify-content-between">
                    <span><i class="fa-solid fa-signature me-2"></i></i>Merk:</span>
                    <span><?= $row['merk']; ?></span>
                </div>
                <div class="text-center mt-5" style="font-size: 14px; color: gray;"><i class="fa-solid fa-triangle-exclamation me-2"></i>Pastikan karcis jangan sampai hilang!</div>

            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        window.addEventListener('load', function() {
            setTimeout(function() {
                window.print();
            }, 2000);
        });
    </script>
</body>
</html>
