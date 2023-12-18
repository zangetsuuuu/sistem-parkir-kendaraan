<?php
include "config/koneksi.php";

session_start();

// Proses login
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (isset($_POST['operator'])) {
        $cek_operator = mysqli_query($conn, "SELECT * FROM operator WHERE username = '$username' AND password = '$password'");

        if (mysqli_num_rows($cek_operator) > 0) {
            $_SESSION["username"] = $username;
            // Login berhasil, redirect ke halaman operator
            header('Location: home.php');
        } else {
            // Login gagal, tampilkan pesan error
            echo "<script>alert('Username atau Password Salah!');
            document.location.href='index.php'</script>";
        }
    } elseif (isset($_POST['admin'])) {
        $cek_admin = mysqli_query($conn, "SELECT * FROM admin WHERE username = '$username' AND password = '$password'");

        if ($cek_admin) {
            $_SESSION["username"] = $username;
            // Login berhasil, redirect ke halaman admin
            header('Location: home_admin.php');
        } else {
            // Login gagal, tampilkan pesan error
            echo "<script>alert('Username atau Password Salah!')</script>";
            exit();
        }
    } else {
        // Belum memilih antara admin atau operator, tampilkan pesan error
        echo "<script>alert('Silakan pilih Admin atau Operator!')
        document.location.href='index.php'</script>";
    }
}
?>