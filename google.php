<?php
require_once 'vendor/autoload.php';
session_start();

$client = new Google_Client();
$client->setClientId('1080368790065-nc3j1se3skp5m0blf56en5dgfc6i7k4f.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('http://localhost/WhatsapiAPI/oauth2callback.php');
$client->addScope('email');
$client->addScope('profile');

// Redirect ke Google untuk autentikasi
if (!isset($_GET['code'])) {
    $authUrl = $client->createAuthUrl();
    header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
    exit();
}
?>