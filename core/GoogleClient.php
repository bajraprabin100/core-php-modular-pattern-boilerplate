<?php

require_once '../vendor/autoload.php';

class GoogleClient
{
    public static function getClient()
    {
        $config = require '../config/config.php';

        $client = new Google_Client();
        $client->setApplicationName('Google Calendar API PHP Quickstart');
        $client->setScopes(Google_Service_Calendar::CALENDAR);
        $client->setAuthConfig($config['client_secret_path']);
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');
        $client->setRedirectUri($config['redirect_uri']);

        $tokenPath = '../config/token.json';
        if (file_exists($tokenPath)) {
            $accessToken = json_decode(file_get_contents($tokenPath), true);
            $client->setAccessToken($accessToken);
        }

        if ($client->isAccessTokenExpired()) {
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            } else {
                $authUrl = $client->createAuthUrl();
                header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
                exit;
            }

            if (!file_exists(dirname($tokenPath))) {
                mkdir(dirname($tokenPath), 0700, true);
            }
            file_put_contents($tokenPath, json_encode($client->getAccessToken()));
        }

        return $client;
    }

    public static function disconnect()
    {
        $tokenPath = '../config/token.json';
        if (file_exists($tokenPath)) {
            unlink($tokenPath);
        }
    }
}
