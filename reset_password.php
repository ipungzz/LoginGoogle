<!DOCTYPE html>
<html lang="en">
<?php
require 'controller/connection.php';
$token = $_GET['token'] ?? '';
$query = mysqli_query($conn, "SELECT * FROM user WHERE token = '$token'"); //RESET PASSWORD FILTER
$select = mysqli_fetch_assoc($query);

if ($select) {
    // Memeriksa apakah ada data hasil dari query
    if (mysqli_num_rows($query) > 0) {
        // Ada data, respon berhasil
        if (isset($_POST['btnVerif'])) {
            if (resetPassword($_POST,$token) > 0) {
                header("Location: login");
            }
        }
    } else {
        // Tidak ada data (hasil null), respon gagal
        echo "tidak ada";
    }
} else {
    // Jika query gagal
    setAlert("403 Forbidden", "Permintaan Anda Ditolak!", "error");
    header("Location: login");
}

?>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Forgot Password</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">Reset Your Password</h1>
                                        <p class="mb-4"></p>
                                    </div>
                                    <form class="user" method="post">
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                name="password1" placeholder="Enter Password" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                name="password2" placeholder="Confirm Password" required>
                                        </div>
                                        <button type="submit" name="btnVerif" class="btn btn-primary btn-user btn-block">Reset</button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="register">Create an Account!</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="login">Already have an account? Login!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>s