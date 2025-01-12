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
  <title>Admin</title>
</head>
<body id="page-top">
    <div id="wrapper">
    
    <?php include 'include/sidebar.php'; ?>
    <?php include 'include/navbar.php'; ?>
    </div>
    
</body>
</html>