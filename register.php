<!DOCTYPE html>
<html lang="en">
<?php
require 'controller/connection.php';
if (isset($_POST['btnRegister'])) {
    //jika 
    $first = htmlspecialchars($_POST['first']);
    $last = htmlspecialchars($_POST['last']);
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $nomer = htmlspecialchars($_POST['nomer']);
    $password1 = htmlspecialchars($_POST['password1']);
    $password2 = htmlspecialchars($_POST['password2']);
    $current_time = time();
    $current_date = date("Y-m-d H:i:s", $current_time);
    $cookie_expiration_time = $current_time + (30 * 24 * 60 * 60);
    if (isset($_POST['checkbox']) && $_POST['checkbox'] == true) {
        if (isset($_COOKIE['first'])) {
            setcookie("first", "");
        }
        if (isset($_COOKIE['last'])) {
            setcookie("last", "");
        }
        if (isset($_COOKIE['username'])) {
            setcookie("username", "");
        }
        if (isset($_COOKIE['email'])) {
            setcookie("email", "");
        }
        if (isset($_COOKIE['nomer'])) {
            setcookie("nomer", "");
        }
        if (isset($_COOKIE['password1'])) {
            setcookie("password1", "");
        }if (isset($_COOKIE['password2'])) {
            setcookie("password2", "");
        }

        if (registerUser($_POST) > 0) {
            header("Location: activation?user=$username");
        }
    } else {
        // Jika checkbox tidak diaktifkan, maka akan muncul alert
        setcookie('first', $first, $cookie_expiration_time);
        setcookie('last', $last, $cookie_expiration_time);
        setcookie('username', $username, $cookie_expiration_time);
        setcookie('email', $email, $cookie_expiration_time);
        setcookie('nomer', $nomer, $cookie_expiration_time);
        setcookie('password1', $password1, $cookie_expiration_time);
        setcookie('password2', $password2, $cookie_expiration_time);
        setAlert("Gagal", "Silahkan Centang CheckBox!", "error");
        header("Location: register");
    }
}


?>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Register</title>

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

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <form class="user" method = "post">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user" name="first"
                                            placeholder="First Name" value="<?php if(isset($_COOKIE["first"])) { echo $_COOKIE["first"]; } ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user" name="last"
                                            placeholder="Last Name" value="<?php if(isset($_COOKIE["last"])) { echo $_COOKIE["last"]; } ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" name="username"
                                        placeholder="Username" value="<?php if(isset($_COOKIE["username"])) { echo $_COOKIE["username"]; } ?>">
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" name="email"
                                        placeholder="Email Address" value="<?php if(isset($_COOKIE["email"])) { echo $_COOKIE["email"]; } ?>">
                                </div>
                                <div class="form-group">
                                    <input type="number" class="form-control form-control-user" name="nomer"
                                        placeholder="Nomer Telpon 08xxx" value="<?php if(isset($_COOKIE["nomer"])) { echo $_COOKIE["nomer"]; } ?>">
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user"
                                            name="password1" placeholder="Password" value="<?php if(isset($_COOKIE["password1"])) { echo $_COOKIE["password1"]; } ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user"
                                            name="password2" placeholder="Repeat Password" value="<?php if(isset($_COOKIE["password2"])) { echo $_COOKIE["password2"]; } ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" class="custom-control-input" id="customCheck" name="checkbox">
                                            <label class="custom-control-label" for="customCheck">Saya telah memastikan bawah data diatas benar!</label>
                                    </div>
                                </div>
                                <button type="submit" name="btnRegister" class="btn btn-primary btn-user btn-block">Register Account</button>
                                <hr>
                                <a href="google" class="btn btn-google btn-user btn-block">
                                    <i class="fab fa-google fa-fw"></i> Register with Google
                                </a>
                                <a href="index" class="btn btn-facebook btn-user btn-block">
                                    <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                                </a>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="forgot-password">Forgot Password?</a>
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

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>