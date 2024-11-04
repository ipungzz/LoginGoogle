<?php
session_start();
include 'include/js.php';
date_default_timezone_set("Asia/Jakarta");

$host		= "localhost";
$username	= "root";
$password	= "";
$database	= "whatsapapi";

$conn 		= mysqli_connect($host, $username, $password, $database);
if ($conn) {
		// echo "berhasil terkoneksi!";
} else {
	echo "gagal terkoneksi!";
}

// ======================================== FUNCTION ========================================
function setAlert($title='', $text='', $type='', $buttons='') {
	$_SESSION["alert"]["title"]		= $title;
	$_SESSION["alert"]["text"] 		= $text;
	$_SESSION["alert"]["type"] 		= $type;
	$_SESSION["alert"]["buttons"]	= $buttons; 
}

if (isset($_SESSION['alert'])) {
	$title 		= $_SESSION["alert"]["title"];
	$text 		= $_SESSION["alert"]["text"];
	$type 		= $_SESSION["alert"]["type"];
	$buttons	= $_SESSION["alert"]["buttons"];

	echo"
	<div id='msg' data-title='".$title."' data-type='".$type."' data-text='".$text."' data-buttons='".$buttons."'></div>
	<script>
	let title 		= $('#msg').data('title');
	let type 		= $('#msg').data('type');
	let text 		= $('#msg').data('text');
	let buttons		= $('#msg').data('buttons');

	if(text != '' && type != '' && title != '') {
		Swal.fire({
			title: title,
			text: text,
			icon: type,
			});
		}
		</script>
		";
		unset($_SESSION["alert"]);
	}

function checkLogin() {
    if (!isset($_SESSION['id_user'])) {
        setAlert("Access Denied!", "Login First!", "error");
        header('Location: login');
    } 
}

function checkLoginAtLogin() {
    if (isset($_SESSION['id_user'])) {
        setAlert("You has been logged!", "Welcome!", "success");
        header('Location: index');
    }
}

function logout() {
    setAlert("You has been logout!", "Success Logout!", "success");
    header("Location: ../login");
}

function sendwa($nosend,$pesand)
	{
        $url = "localhost:8080/postapi?";
        $key = "SIPALINGNT";
		global $conn;
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "$url/postapi",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "nomer=$nosend&pesan=$pesand&key=$key",
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"content-type: application/x-www-form-urlencoded"
			),
		));
		curl_exec($curl);

		curl_close($curl);
		return mysqli_affected_rows($conn);

	};

function resetPassword($data,$id){
    global $conn;
    $password = htmlspecialchars($_POST['password1']);
    $password_verify = htmlspecialchars($_POST['password2']);
    if ($password !== $password_verify) {
        setAlert("Failed to Reset!", "password not same password verify!", "error");
        return header("Location: reset_password?token=$id");
    } else {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $query = mysqli_query($conn, "UPDATE user SET password = '$password', token='', token_expiration='' WHERE token = '$id'");
        setAlert("Succes Reset Password!", "Login Ulang!", "success");
        return mysqli_affected_rows($conn);
    }
}

function forgotPassword($data){
    global $conn;
    $nomer = htmlspecialchars($data['number']);
    $token = mt_rand(100000, 999999);
    $token_expiration = date('Y-m-d H:i:s', strtotime('+1 hour'));
    $query = mysqli_query($conn, "UPDATE user SET token = '$token', token_expiration = '$token_expiration' WHERE notelp = '$nomer'");
    $select = mysqli_query($conn, "SELECT * FROM user WHERE notelp = '$nomer'");
    if ($select) {
        // Memeriksa apakah ada data hasil dari query
        if (mysqli_num_rows($select) > 0) {
            // Ada data, respon berhasil
            $pesan = "HATI - HATI PENIPUAN, Abaikan Pesan ini jika anda tidak merasa melakukan apapun!
token: $token";
    $_SESSION = [
        'id' => $data['token'],
    ];
    sendwa($nomer,$pesan);
    setAlert("Succes Register!", "Please Activation!", "success");
    return mysqli_affected_rows($conn);
        } else {
            // Tidak ada data (hasil null), respon gagal
            setAlert("Gagal!", "nomer tidak ditemukan!", "error");
            header("Location: forgot-password");
        }
    } else {
        // Jika query gagal
        //echo "Gagal menjalankan query.";
    }
}

function verifPassword($data){
    global $conn;
    $token = htmlspecialchars($data['number']);
    $token_hash = hash("sha256", $token);
    if ($token_hash) {
        // Query untuk memeriksa apakah token valid dan belum kedaluwarsa
        $query = "SELECT * FROM user WHERE token = ? AND token_expiration > NOW()";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $token);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    
        if (mysqli_num_rows($result) > 0) {
            // Token valid, redirect ke halaman reset password
            $_SESSION = [
                'username' => $data['username'],
            ];
            header("Location: reset_password?token=$token");
            return mysqli_affected_rows($conn);
        } else {
            // Token tidak valid atau sudah kedaluwarsa
            setAlert("Token tidak valid atau sudah kedaluwarsa!", "Cek Ulang Token!", "error");
            header("Location: verif_token");
        }
    } else {
        setAlert("Token tidak ditemukan", "Periksa Kembali token!", "error");
        header("Location: verif_token");
    }
}

function verifToken($data){
    global $conn;
    $token = htmlspecialchars($data['number']);
    $token_hash = hash("sha256", $token);
    if ($token_hash) {
        // Query untuk memeriksa apakah token valid dan belum kedaluwarsa
        $query = "SELECT * FROM user WHERE token = ? AND token_expiration > NOW()";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $token);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    
        if (mysqli_num_rows($result) > 0) {
            // Token valid, redirect ke halaman reset password
            mysqli_query($conn, "UPDATE user SET token = '', token_expiration = '', status='true' WHERE token = '$token'");
            setAlert("Succes!", "Berhasil melakukan aktivasi, silahkan login!", "success");
            header("Location: login");
            exit();
        } else {
            // Token tidak valid atau sudah kedaluwarsa
            setAlert("Token tidak valid atau sudah kedaluwarsa!", "Cek Ulang Token!", "error");
            header("Location: activation");
        }
    } else {
        setAlert("Token tidak ditemukan", "Periksa Kembali token!", "error");
        header("Location: activation");
    }
}

function registerUser($data){
    global $conn;
    $token = mt_rand(100000, 999999);
    $first = htmlspecialchars($data['first']);
    $last = htmlspecialchars($data['last']);
    $username = htmlspecialchars($data['username']);
    $email = htmlspecialchars($data['email']);
    $nomer = htmlspecialchars($data['nomer']);
    $password1 = htmlspecialchars($data['password1']);
    $password2 = htmlspecialchars($data['password2']);
    $query = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
    $token_expiration = date('Y-m-d H:i:s', strtotime('+1 hour'));
    if (mysqli_fetch_assoc($query)) {
        setAlert("Failed to add user!", "Username has been used!", "error");
        return header("Location: register");
    } else {
        $password = htmlspecialchars($data['password1']);
        $password_verify = htmlspecialchars($data['password2']);
        if ($password !== $password_verify) {
            setAlert("Failed to add user!", "password not same password verify!", "error");
            return header("Location: register");
        } else {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $nama_lengkap = "$first"."$last";
            $_SESSION = [
                'username' => $data['username'],
            ];
            $query = mysqli_query($conn, "INSERT INTO user (`username`,`name`,`password`,`email`,`notelp`, `token`, `token_expiration`, `status`) VALUES ('$username', '$nama_lengkap', '$password', '$email', '$nomer', '$token', '$token_expiration', 'false')");
            $pesan = "[Project] Please Activation Your Account
            
Hey $nama_lengkap!

Your Code: $token Use to Activation Your Account

Salam Hormat,
Small Project";
            sendwa($nomer,$pesan);
            setAlert("Succes Register!", "Please Activation!", "success");
            return mysqli_affected_rows($conn);
        }
    }
    return mysqli_affected_rows($conn);
}


?>