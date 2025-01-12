<?php
require_once '../vendor/autoload.php';
session_start();

$client = new Google_Client();
$client->setClientId('854576687113-rs51j39mn5ek8cefdnu0es2bb5tm15lo.apps.googleusercontent.com');
$client->setClientSecret('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');
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