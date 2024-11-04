
<!DOCTYPE html>
<?php
require 'controller/connection.php';
checkLogin();
if (!isset($_SESSION['id_user'])) {
    // Jika belum login, beri alert dan redirect ke halaman login
    setAlert("Access Denied!", "Login First!", "error");
    header('Location: login');
    exit();
} else {
    // Jika sudah login, cek apakah status user adalah false
    if ($_SESSION['status'] !== "true") {
        // Jika status false, beri alert dan redirect ke halaman logout atau nonaktif
        setAlert("Akun Anda tidak aktif!", "Silahkan Aktivasi Terlebih Dahulu.", "error");
        header('Location: controller/logout'); // Atau arahkan ke halaman lain sesuai logika aplikasi Anda
        exit();
    }
}
$username = $_SESSION['id_user'];
echo $username;
?>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    
</body>

</html>