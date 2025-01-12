<?php
require 'controller/connection.php';
$id = $_SESSION['id_user'];
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