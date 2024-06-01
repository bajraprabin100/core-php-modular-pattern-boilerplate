<?php

require_once '../vendor/autoload.php';
require_once '../core/GoogleClient.php';

$config = require '../config/config.php';
$client = new Google_Client();
$client->setAuthConfig($config['client_secret_path']);
$client->setRedirectUri($config['redirect_uri']);

if (isset($_GET['code'])) {
    $client->authenticate($_GET['code']);
    $accessToken = $client->getAccessToken();
    file_put_contents('../config/token.json', json_encode($accessToken));
    header('Location: /');
    exit;
} else {
    echo "Authorization code not received.";
}
