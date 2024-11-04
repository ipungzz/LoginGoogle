<!DOCTYPE html>
<html lang="en">
<?php 
require 'controller/connection.php';
checkLoginAtLogin();
if (isset($_POST['btnLogin'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	$current_time = time();
	$current_date = date("Y-m-d H:i:s", $current_time);

	// Set Cookie expiration for 1 month
    $cookie_expiration_time = $current_time + (30 * 24 * 60 * 60);

    // Query untuk mengecek apakah username ada di database
    $checkUsername = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
    if ($data = mysqli_fetch_assoc($checkUsername)) {
        // Memeriksa password yang diinput dengan hash password di database
        if (password_verify($password, $data['password'])) {

            // Memeriksa apakah status user true atau false
            if ($data['status'] == "true") {
                // Jika status true, proses login berhasil
                
                // Cek apakah remember-me diaktifkan untuk menyimpan cookie
                if (isset($_POST['remember-me']) && $_POST['remember-me'] == true) {
                    setcookie('username', $username, $cookie_expiration_time);
                    setcookie('password', $password, $cookie_expiration_time);
                } else {
                    // Jika remember-me tidak diaktifkan, hapus cookie jika ada
                    if (isset($_COOKIE['username'])) {
                        setcookie("username", "");
                    }
                    if (isset($_COOKIE['password'])) {
                        setcookie("password", "");
                    }
                }

                // Inisialisasi session
                $_SESSION = [
                    'id_user' => $data['id_user'],
                    'username' => $data['username'],
                    'status' => $data['status'],
                ];

                // Redirect ke halaman index setelah berhasil login
                setAlert("Login Berhasil!", "Berhasil Login.", "success");
                header("Location: index.php");
                exit();

            } else {
                // Jika status false, user tidak bisa login
                setAlert("Akun Anda tidak aktif!", "Silahkan Aktivasi Terlebih Dahulu.", "error");
                header("Location: activation?user=$username");
                exit();
            }

        } else {
            // Jika password salah
            setAlert("Password yang Anda masukkan salah!", "Periksa kembali password Anda.", "error");
            header("Location: login.php");
            exit();
        }
    } else {
        // Jika username tidak ditemukan
        setAlert("Username tidak terdaftar!", "Periksa kembali username Anda.", "error");
        header("Location: login.php");
        exit();
    }
}
?>
<style>
        .password-field {
            position: relative;
        }
        .password-field .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Login</title>

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
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    <form class="user" method="post">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                name="username" aria-describedby="emailHelp"
                                                placeholder="Username" value="<?php if(isset($_COOKIE["username"])) { echo $_COOKIE["username"]; } ?>" >
                                        </div>
                                        <div class="form-group password-field">
                                            <input type="password" class="form-control form-control-user"
                                                name="password" id="password" placeholder="Password" value="<?php if(isset($_COOKIE["password"])) { echo $_COOKIE["password"]; } ?>">
                                            <span toggle="#password" class="fa fa-fw fa-eye toggle-password"></span>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck" name="remember-me" <?php if(isset($_COOKIE["username"])) { ?> checked <?php } ?>>
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <button type="submit" name="btnLogin" class="btn btn-primary btn-user btn-block">Login</button>
                                        <hr>
                                        <a href="google" class="btn btn-google btn-user btn-block">
                                            <i class="fab fa-google fa-fw"></i> Login with Google
                                        </a>
                                        <a href="index" class="btn btn-facebook btn-user btn-block">
                                            <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                                        </a>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="forgot-password">Forgot Password?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="register">Create an Account!</a>
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
    <script>
        document.querySelector('.toggle-password').addEventListener('click', function () {
            const passwordField = document.getElementById('password');
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash'); // Toggle icon
        });
    </script>
</body>

</html>