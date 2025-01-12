<?php
require_once '../vendor/autoload.php';
session_start();

$client = new Google_Client();
$client->setClientId('xxxx');
$client->setClientSecret('xxxx');
$client->setRedirectUri('http://localhost/WhatsapiAPI/controller/oauth2callback.php');
$client->addScope('email');
$client->addScope('profile');

// Redirect ke Google untuk autentikasi
if (!isset($_GET['code'])) {
    $authUrl = $client->createAuthUrl();
    header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
    exit();
}
?>