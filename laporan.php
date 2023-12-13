<?php
require "assets/library/fpdf/fpdf.php";
include "config/koneksi.php";

// Mulai dokumen PDF
$pdf = new FPDF();
$pdf->AddPage('A4');
$pdf->SetTitle('Laporan Parkir');

// Judul tabel
$pdf->SetFont('Helvetica','B',10);
$pdf->Cell(10,10,'No',1,0,'C');
$pdf->Cell(30,10,'ID Parkir',1,0,'C');
$pdf->Cell(30,10,'Plat Nomor',1,0,'C');
$pdf->Cell(40,10,'Jenis Kendaraan',1,0,'C');
$pdf->Cell(30,10,'Merk',1,0,'C');
$pdf->Cell(50,10,'Waktu Masuk',1,0,'C');
$pdf->Cell(50,10,'Waktu Keluar',1,0,'C');
$pdf->Cell(40,10,'Biaya Parkir',1,1,'C');

// Query data dari database
$no = 1;
$result = mysqli_query($conn, "SELECT * FROM parkir");

// Looping untuk menampilkan data dalam tabel PDF
while ($row = mysqli_fetch_array($result)) {
    $pdf->Cell(10,10,$no++,1,0,'C');
    $pdf->Cell(30,10,$row['id_parkir'],1,0,'C');
    $pdf->Cell(30,10,$row['plat_nomor'],1,0,'C');
    $pdf->Cell(40,10,$row['jenis_kendaraan'],1,0,'C');
    $pdf->Cell(30,10,$row['merk'],1,0,'C');
    $pdf->Cell(50,10,date('d-m-Y, H:i:s', strtotime($row['waktu_masuk'])).' WIB',1,0,'C');
    $pdf->Cell(50,10,($row['waktu_keluar'] == null) ? '---' : date('d-m-Y, H:i:s', strtotime($row['waktu_keluar'])).' WIB',1,0,'C');
    $pdf->Cell(40,10,'RP. '.$row['biaya_parkir'],1,1,'C');
}

// Output sebagai laporan.pdf
$pdf->Output();
?>