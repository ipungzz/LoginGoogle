<?php
require 'controller/connection.php';
$id = $_SESSION['id_user'];
if (!isset($_SESSION['id_user'])) {
    // Jika belum login, beri alert dan redirect ke halaman login
    setAlert("Akses Ditolak", "Login First!", "error");
    header('Location: login');
    exit();
} else {
    // Jika sudah login, cek apakah status user adalah false
    if ($_SESSION['status'] !== "true") {
        // Jika status false, beri alert dan redirect ke halaman logout atau nonaktif
        setAlert("Akun Anda tidak aktif!", "Silahkan Aktivasi Terlebih Dahulu.", "error");
        header('Location: controller/logout'); // Atau arahkan ke halaman lain sesuai logika aplikasi Anda
        exit();
    }else{
        if($_SESSION['role'] !== 'admin'){
            setAlert("Akses Ditolak", "Maaf $_SESSION[name] anda tidak memiliki akses!", "error");
            header("Location: index");
        }
    }
}
//$uang_kas = mysqli_query($conn, "SELECT * FROM uang_kas INNER JOIN siswa ON uang_kas.id_siswa = siswa.id_siswa INNER JOIN bulan_pembayaran ON uang_kas.id_bulan_pembayaran = bulan_pembayaran.id_bulan_pembayaran WHERE uang_kas.id_bulan_pembayaran = '$id_bulan_pembayaran' ORDER BY nama_siswa ASC");
$data = mysqli_query($conn, "SELECT * FROM aktifitas_login INNER JOIN user ON aktifitas_login.id_user = user.id_user WHERE aktifitas_login.id_user = '$id'");
?>
<!DOCTYPE html>
<html>
<head>
<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
<link href="css/sb-admin-2.min.css" rel="stylesheet">
  <title>activityLog</title>
</head>
<body id="page-top">
    <div id="wrapper">
    
    <?php include 'include/sidebar.php'; ?>
    <?php include 'include/navbar.php'; ?>
    <div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Aktifitas Login</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal & waktu</th>
                    </tr>
                </thead>

                <tbody>
                <?php $i = 1; ?>
                <?php foreach ($data as $duk): ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $duk['tanggal']; ?></td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
    </div>
</body>
</html>