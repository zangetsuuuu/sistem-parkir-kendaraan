<?php
include "config/koneksi.php";

if (isset($_POST["keluar"])) {
    $id_parkir = $_POST["id_parkir"];

    // Tambahkan kondisi untuk menampilkan pesan jika status_parkir sudah 'Keluar'
    $cek_status = mysqli_query($conn, "SELECT status_parkir FROM parkir WHERE id_parkir = '$id_parkir'");
    $result_status = mysqli_fetch_assoc($cek_status);
    if ($result_status['status_parkir'] == 'Keluar') {
        echo "<script>alert('Kendaraan sudah keluar parkir')</script>";
        echo "<script>window.location.href='home.php'</script>";
        exit;
    }

    // Tambah waktu keluar
    $update_keluar = mysqli_query($conn, "UPDATE parkir SET waktu_keluar = NOW() WHERE id_parkir = '$id_parkir'");

    // Hitung biaya
    $result = mysqli_query($conn, "SELECT * FROM parkir WHERE id_parkir = '$id_parkir'");
    
    if ($result) {
        $row = $result->fetch_assoc();
        $waktu_masuk = strtotime($row['waktu_masuk']);
        $waktu_keluar = strtotime($row['waktu_keluar']);

        // Menghitung selisih waktu dalam jam
        $selisihJam = ($waktu_keluar - $waktu_masuk) / 3600;

        // Menghitung biaya parkir berdasarkan jenis kendaraan
        $biayaParkir = 0;
        $jenisKendaraan = $row['jenis_kendaraan'];
        if ($jenisKendaraan == 'Motor') {
            $biayaParkir = 2000 * $selisihJam;
        } elseif ($jenisKendaraan == 'Mobil') {
            $biayaParkir = 5000 * $selisihJam;
        } else {
            $biayaParkir = 7000 * $selisihJam;
        }

        $simpan = mysqli_query($conn, "UPDATE parkir SET biaya_parkir = '$biayaParkir' WHERE id_parkir = '$id_parkir'");
        if (!$simpan) {
            echo "Gagal menyimpan hasil biaya parkir ke dalam database.";
        }
    } else {
        echo "<script>alert('ID Parkir tidak ditemukan')</script>";
    }

    // Update status parkir menjadi 'Keluar'
    $update_status = mysqli_query($conn, "UPDATE parkir SET status_parkir = 'Keluar' WHERE id_parkir = '$id_parkir'");
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/images/favicon.svg">
    <title>Biaya Parkir</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .popup {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1;
        }

        .popup-inner {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            max-width: 100%;
            text-align: center;
        }

        /* Style untuk judul */
        .popup-inner h4 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #333;
        }

        /* Style untuk garis pemisah */
        .popup-inner hr {
            border: 1px solid #ddd;
            margin: 15px 0;
        }

        /* Style untuk teks biaya parkir */
        .popup-inner p {
            font-size: 18px;
            margin-bottom: 20px;
            color: #555;
        }

        /* Style untuk tombol OK */
        .btn-ok {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-ok:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div class="popup">
        <div class="popup-inner">
            <h4>Biaya Parkir</h4>
            <hr>
            <p style="font-size: 16px;">Rp
                <?= number_format(round($biayaParkir), 0, ',', '.'); ?>
            </p>
            <button class="btn-ok" onclick="closePopup()">OK</button>
        </div>
    </div>

    <script>
        function closePopup() {
            document.querySelector('.popup').style.display = 'none';
            window.location.href = "home.php";
        }
    </script>
</body>

</html>