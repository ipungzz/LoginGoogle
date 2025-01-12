<?php
require '../controller/connection.php'; // Pastikan file ini berisi koneksi database
require_once '../vendor/autoload.php';
$client = new Google_Client();
$client->setClientId('854576687113-rs51j39mn5ek8cefdnu0es2bb5tm15lo.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('http://localhost/WhatsapiAPI/controller/oauth2callback.php');
$client->addScope('email');
$client->addScope('profile');

if (isset($_GET['code'])) {
    $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $_SESSION['access_token'] = $client->getAccessToken();

    $oauth2 = new Google_Service_Oauth2($client);
    $userInfo = $oauth2->userinfo->get();

    $username = $userInfo->email; // Email sebagai username
    $name = $userInfo->name; // Nama pengguna

    // Cek apakah pengguna sudah ada di database
    $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    $checkUsername = mysqli_query($conn, "SELECT * FROM user WHERE email = '$username'");
    $data = mysqli_fetch_assoc($checkUsername);
    if ($result->num_rows > 0) {
        // Pengguna sudah ada, arahkan ke halaman index
        $_SESSION = [
                    'id_user' => $data['id_user'],
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'status' => $data['status'],
                    'role' => $data['role'],
                ];
        setAlert("Login Berhasil!", "Berhasil Login.", "success");
        if($_SESSION['role'] == 'admin'){
            header("Location: ../admin");
        }else{
            header("Location: ../index");
        }
        exit();
    } else {
        $token = mt_rand(100000, 999999);
        // Pengguna belum ada, tambahkan ke database
        mysqli_query($conn, "INSERT INTO user (`role`,`username`,`name`,`password`,`email`,`notelp`, `token`, `token_expiration`, `status`) VALUES ('user','$token', '$name', '', '$username', '', '', '', 'true')");
        if ($stmt->execute()) {
            // Simpan data pengguna di session
            $_SESSION['user_email'] = `$username`;
            $_SESSION['user_name'] = `$name`;

            // Arahkan ke halaman index
            setAlert("Pendaftaran Berhasil!", "Berhasil Melakukan Pendaftaran.", "success");
            header('Location: login'); // Pastikan ini adalah file yang tepat
            exit();
        } else {
            echo "Error: " . $stmt->error; // Menampilkan kesalahan jika eksekusi gagal
        }
    }
} else {
    echo "No authorization code provided.";
}
?>