<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "sistem_parkir";
$conn = mysqli_connect($host, $user, $pass, $db) or die("Koneksi gagal!". mysqli_connect_error());