<!DOCTYPE html>
<html lang="en">
<?php
// Set waktu akhir countdown dalam detik dari sekarang (misalnya 1 menit = 60 detik)
$time_limit = 5; // Durasi waktu mundur (dalam detik)
// Mendapatkan waktu sekarang dalam format timestamp
$current_time = time();
// Menentukan waktu akhir countdown
$end_time = $current_time + $time_limit;
require 'controller/connection.php';

$user = $_GET['user'] ?? '';
$query = mysqli_query($conn, "SELECT * FROM user WHERE username = '$user'");
$select = mysqli_fetch_assoc($query);
if ($select) {
    // Memeriksa apakah ada data hasil dari query
    if (mysqli_num_rows($query) > 0) {
        // Ada data, respon berhasil
        if (isset($_POST['btnVerif'])) {
            if (verifToken($_POST) > 0) {
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
//Pesan Kirim Ulang OTP
$pesan = "[Project] Please Activation Your Account Hey $select[name]! Your Code: $select[token] Use to Activation Your Account. Salam Hormat, Small Project";
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
                                        <h1 class="h4 text-gray-900 mb-2">Send Your Code</h1>
                                        <p class="mb-4">Masukan Kode untuk mengaktifkan akun anda!</p>
                                    </div>
                                    <form class="user" method="post" id="otpForm">
                                        <div class="form-group">
                                        <input type="hidden" name="nomer" id="nomer" value ="<?php echo $select['notelp']?>">
                                        <input type="hidden" name="pesan" id="pesan" value="<?php echo $pesan?>">
                                            <input type="number" class="form-control form-control-user"
                                                name="number" placeholder="Enter Code">
                                        </div>
                                        <div class="form-group">
                                           <label class="">Kirim Ulang OTP </label> <span id="countdown"></span>
                                        </div>
                                        <button type="submit" name="btnVerif" class="btn btn-primary btn-user btn-block">Verif</button>
                                    </form>
                                    <hr>
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
    <script src="controller/2.js"></script>
    <script>var endTime = <?php echo $end_time * 1000; ?>; // Convert to milliseconds</script>
    <script>startCountdown();</script>
</body>

</html>