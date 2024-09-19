<?php
require 'vendor/autoload.php';

function getClient() {
    $client = new Google_Client();
    $client->setApplicationName('Medical Appointment Scheduler');
    $client->setScopes(Google_Service_Calendar::CALENDAR);
    $client->setAuthConfig('C:\xampp\htdocs\prog4\client_secret_1090369482239-j80r62hianiokkuq94e23dr472aermui.apps.googleusercontent.com.json');
    $client->setAccessType('offline');
    $client->setPrompt('select_account consent');

    // Carregar token previamente salvo
    $tokenPath = 'token.json';
    if (file_exists($tokenPath)) {
        $accessToken = json_decode(file_get_contents($tokenPath), true);
        $client->setAccessToken($accessToken);
    }

    // Se o token expirou, obtenha um novo token
    if ($client->isAccessTokenExpired()) {
        if ($client->getRefreshToken()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        } else {
            $authUrl = $client->createAuthUrl();
            printf("Open the following link in your browser:\n%s\n", $authUrl);
            print 'Enter verification code: ';
            $authCode = trim(fgets(STDIN));

            // Trocar o código de autenticação por um token de acesso
            $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
            $client->setAccessToken($accessToken);

            // Salvar token para futuras execuções
            if (!file_exists(dirname($tokenPath))) {
                mkdir(dirname($tokenPath), 0700, true);
            }
            file_put_contents($tokenPath, json_encode($client->getAccessToken()));
        }
    }

    return $client;
}
