<?php
require 'controller/connection.php';
checkLoginAtLogin();
$token = $_GET["token"];
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
        header("Location: reset_password.php?token=" . $token);
        exit();
    } else {
        // Token tidak valid atau sudah kedaluwarsa
        echo "Token tidak valid atau sudah kedaluwarsa.";
    }
} else {
    echo "Token tidak ditemukan.";
}
?>