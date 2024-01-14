<?php
require_once "assets/library/fpdf/fpdf.php";
include "config/koneksi.php";
include "login.php";

// Mulai dokumen PDF
$pdf = new FPDF();
$pdf->AddPage('A4');
$pdf->SetTitle('Laporan Parkir');

// Judul laporan
$pdf->SetFont('Arial', 'B', 24);
$pdf->Cell(10, 5, '', 0, 1);
$pdf->Cell(280, 7, 'LAPORAN DAFTAR PARKIR KENDARAAN', 0, 1, 'C');

$id_laporan = "L" . rand(100, 999);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'ID Laporan: ' . $id_laporan, 0, 1, 'C');
$pdf->Cell(10, 5, '', 0, 1);

$keterangan = "";
$jenis_laporan = "";

if (isset($_GET["all"])) {

    // Informasi pembuat laporan
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 10, "Dibuat oleh: " . ucwords($_SESSION['username']) . ", pada tanggal: " . date('d-m-Y'), 0, 1, 'C');

    // Judul tabel
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(10, 10, 'No', 1, 0, 'C');
    $pdf->Cell(30, 10, 'ID Parkir', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Plat Nomor', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Jenis Kendaraan', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Merk', 1, 0, 'C');
    $pdf->Cell(50, 10, 'Waktu Masuk', 1, 0, 'C');
    $pdf->Cell(50, 10, 'Waktu Keluar', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Biaya Parkir', 1, 1, 'C');

    // Query data dari database
    $no = 1;
    $result = mysqli_query($conn, "SELECT * FROM parkir ORDER BY waktu_masuk DESC");

    // Looping untuk menampilkan data dalam tabel PDF
    $pdf->SetFont('Arial', '', 10);
    while ($row = mysqli_fetch_array($result)) {
        $pdf->Cell(10, 10, $no++, 1, 0, 'C');
        $pdf->Cell(30, 10, $row['id_parkir'], 1, 0, 'C');
        $pdf->Cell(30, 10, $row['plat_nomor'], 1, 0, 'C');
        $pdf->Cell(40, 10, $row['jenis_kendaraan'], 1, 0, 'C');
        $pdf->Cell(30, 10, $row['merk'], 1, 0, 'C');
        $pdf->Cell(50, 10, date('d-m-Y, H:i:s', strtotime($row['waktu_masuk'])) . ' WIB', 1, 0, 'C');
        $pdf->Cell(50, 10, ($row['waktu_keluar'] == null) ? '---' : date('d-m-Y, H:i:s', strtotime($row['waktu_keluar'])) . ' WIB', 1, 0, 'C');
        $pdf->Cell(40, 10, 'RP. ' . $row['biaya_parkir'], 1, 1, 'C');
    }

    $jenis_laporan = "Semua Data";
    $keterangan = $_GET["keterangan"];
    $pdfPath = "laporan/laporan_" . $id_laporan . ".pdf";
    $file = mysqli_real_escape_string($conn, $pdfPath);
    mysqli_query($conn, "INSERT INTO laporan (id_laporan, username_operator, jenis_laporan, tanggal_dibuat, keterangan, file_laporan) VALUES ('$id_laporan', '{$_SESSION['username']}', '$jenis_laporan', NOW(), '$keterangan', '$file')");

    // Informasi keterangan
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(10, 5, '', 0, 1,);
    $pdf->Cell(0, 10, 'Keterangan: ' . $keterangan, 0, 1, 'C');
}

elseif (isset($_GET["tanggal"])) {

    // Informasi pembuat laporan
    $pdf->SetFont('Arial', 'B', 10);
    $tanggal = $_GET['tanggal'];
    $pdf->Cell(0, 10, "Dibuat oleh: " . ucwords($_SESSION['username']) . ", pada tanggal: " . date('d-m-Y') . "   |   Daftar parkir pada tanggal: " . date('d-m-Y', strtotime($tanggal)), 0, 1, 'C');

    // Judul tabel
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(10, 10, 'No', 1, 0, 'C');
    $pdf->Cell(30, 10, 'ID Parkir', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Plat Nomor', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Jenis Kendaraan', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Merk', 1, 0, 'C');
    $pdf->Cell(50, 10, 'Waktu Masuk', 1, 0, 'C');
    $pdf->Cell(50, 10, 'Waktu Keluar', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Biaya Parkir', 1, 1, 'C');

    // Query data dari database
    $no = 1;
    $result = mysqli_query($conn, "SELECT * FROM parkir WHERE waktu_masuk LIKE '%$tanggal%'");

    // Looping untuk menampilkan data dalam tabel PDF
    $pdf->SetFont('Arial', '', 10);
    while ($row = mysqli_fetch_array($result)) {
        $pdf->Cell(10, 10, $no++, 1, 0, 'C');
        $pdf->Cell(30, 10, $row['id_parkir'], 1, 0, 'C');
        $pdf->Cell(30, 10, $row['plat_nomor'], 1, 0, 'C');
        $pdf->Cell(40, 10, $row['jenis_kendaraan'], 1, 0, 'C');
        $pdf->Cell(30, 10, $row['merk'], 1, 0, 'C');
        $pdf->Cell(50, 10, date('d-m-Y, H:i:s', strtotime($row['waktu_masuk'])) . ' WIB', 1, 0, 'C');
        $pdf->Cell(50, 10, ($row['waktu_keluar'] == null) ? '---' : date('d-m-Y, H:i:s', strtotime($row['waktu_keluar'])) . ' WIB', 1, 0, 'C');
        $pdf->Cell(40, 10, 'RP. ' . $row['biaya_parkir'], 1, 1, 'C');
    }

    $jenis_laporan = "Per Tanggal";
    $keterangan = $_GET["keterangan"];
    $pdfPath = "laporan/laporan_" . $id_laporan . ".pdf";
    $file = mysqli_real_escape_string($conn, $pdfPath);
    mysqli_query($conn, "INSERT INTO laporan (id_laporan, username_operator, jenis_laporan, tanggal_dibuat, keterangan, file_laporan) VALUES ('$id_laporan', '{$_SESSION['username']}', '$jenis_laporan', NOW(), '$keterangan', '$file')");

    // Informasi keterangan
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(10, 5, '', 0, 1,);
    $pdf->Cell(0, 10, 'Keterangan: ' . $keterangan, 0, 1, 'C');
}

elseif (isset($_GET["jenis_kendaraan"])) {

    // Informasi pembuat laporan
    $pdf->SetFont('Arial', 'B', 10);
    $jenis_kendaraan = $_GET['jenis_kendaraan'];
    $pdf->Cell(0, 10, "Dibuat oleh: " . ucwords($_SESSION['username']) . ", pada tanggal: " . date('d-m-Y') . "   |   Daftar parkir dengan jenis kendaraan: " . $jenis_kendaraan, 0, 1, 'C');

    // Judul tabel
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(10, 10, 'No', 1, 0, 'C');
    $pdf->Cell(30, 10, 'ID Parkir', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Plat Nomor', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Jenis Kendaraan', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Merk', 1, 0, 'C');
    $pdf->Cell(50, 10, 'Waktu Masuk', 1, 0, 'C');
    $pdf->Cell(50, 10, 'Waktu Keluar', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Biaya Parkir', 1, 1, 'C');

    // Query data dari database
    $no = 1;
    $result = mysqli_query($conn, "SELECT * FROM parkir WHERE jenis_kendaraan LIKE '%$jenis_kendaraan%'");

    // Looping untuk menampilkan data dalam tabel PDF
    $pdf->SetFont('Arial', '', 10);
    while ($row = mysqli_fetch_array($result)) {
        $pdf->Cell(10, 10, $no++, 1, 0, 'C');
        $pdf->Cell(30, 10, $row['id_parkir'], 1, 0, 'C');
        $pdf->Cell(30, 10, $row['plat_nomor'], 1, 0, 'C');
        $pdf->Cell(40, 10, $row['jenis_kendaraan'], 1, 0, 'C');
        $pdf->Cell(30, 10, $row['merk'], 1, 0, 'C');
        $pdf->Cell(50, 10, date('d-m-Y, H:i:s', strtotime($row['waktu_masuk'])) . ' WIB', 1, 0, 'C');
        $pdf->Cell(50, 10, ($row['waktu_keluar'] == null) ? '---' : date('d-m-Y, H:i:s', strtotime($row['waktu_keluar'])) . ' WIB', 1, 0, 'C');
        $pdf->Cell(40, 10, 'RP. ' . $row['biaya_parkir'], 1, 1, 'C');
    }

    $jenis_laporan = "Jenis Kendaraan";
    $keterangan = $_GET["keterangan"];
    $pdfPath = "laporan/laporan_" . $id_laporan . ".pdf";
    $file = mysqli_real_escape_string($conn, $pdfPath);
    mysqli_query($conn, "INSERT INTO laporan (id_laporan, username_operator, jenis_laporan, tanggal_dibuat, keterangan, file_laporan) VALUES ('$id_laporan', '{$_SESSION['username']}', '$jenis_laporan', NOW(), '$keterangan', '$file')");

    // Informasi keterangan
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(10, 5, '', 0, 1,);
    $pdf->Cell(0, 10, 'Keterangan: ' . $keterangan, 0, 1, 'C');
}

// Output
ob_start();
$pdf->Output($pdfPath, 'F');
ob_end_flush();
$pdf->Output();
?>
