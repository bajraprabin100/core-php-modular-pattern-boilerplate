<?php
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
return [
    'env' => $_ENV['ENVIRONMENT'],
    'db' => [
        'host' => $_ENV['DB_HOST'],
        'dbname' => $_ENV['DB_NAME'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
    ],
    'client_secret_path' => __DIR__ . '/'. $_ENV['GOOGLE_CALENDER_FILE_NAME'],
    'redirect_uri' => $_ENV['GOOGLE_OAUTH_REDIRECT_URI'],
];
?>