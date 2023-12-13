<?php include_once "config/koneksi.php";

if (isset($_GET['id'])) {

    $result = mysqli_query($conn, "DELETE FROM operator WHERE id_operator = '$_GET[id]' ");
        
    if ($result) {
        echo "<script>alert('Data berhasil dihapus!')</script>";
        echo "<script>window.location.href='home_admin.php';</script>";
    } else {
        echo "<script>alert('Data gagal dihapus!');</script>";
        echo "<script>window.location.href='home_admin.php';</script>";
    }  
}

$conn->close();
?>