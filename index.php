<?php include "config/koneksi.php";

session_start();

// Proses login
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM operator WHERE username = '$username' AND password = '$password'");

    if ($result) {
        $_SESSION["username"] = $username;
        header("location: home.php");
    } else {
        echo "<script>alert('Username atau Password Salah!');
        document.location.href='index.php'</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Halaman Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="config/style.css">
</head>
<body>
    <nav class="navbar navbar-light bg-light p-3">
        <div class="navbar-brand">
            <img src="https://cdns.iconmonstr.com/wp-content/releases/preview/2016/240/iconmonstr-car-21.png" width="30" height="30" class="d-inline-block align-top" alt="">
            <span class="font-weight-bold" style="letter-spacing: 0.5px;">SISTEM PARKIR KENDARAAN</span>
        </div>
        <span class="navbar-text">
            <?php
            date_default_timezone_set('Asia/Jakarta');
            $hari = date('l');
            $tanggal = date('d F Y');
            echo $hari . ', ' . $tanggal;
            ?>
        </span>
    </nav>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="h3 text-center mb-4 mt-5">Login Operator</div>
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" href="index.php">Operator</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" style="color: grey;" href="admin.php">Admin</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control" name="username" required>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <button type="submit" name="login" class="btn btn-primary btn-block mt-4" style="letter-spacing: 1.5px;">LOGIN</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

