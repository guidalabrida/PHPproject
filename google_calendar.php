<?php

require_once 'vendor/autoload.php';

session_start();

// Inicializar o cliente do Google
$client = new Google\Client();
$client->setApplicationName('Google Calendar API PHP Integration');
$client->setScopes(Google_Service_Calendar::CALENDAR);
$client->setAuthConfig('C:\xampp\htdocs\prog4\client_secret_1090369482239-j80r62hianiokkuq94e23dr472aermui.apps.googleusercontent.com.json'); // Certifique-se de que o arquivo credentials.json está no caminho correto
$client->setAccessType('offline');

// Verifique se temos um token de acesso
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    $client->setAccessToken($_SESSION['access_token']);

    // Crie uma instância do serviço do Calendar
    $service = new Google_Service_Calendar($client);

    // Definir os detalhes do evento
    $event = new Google_Service_Calendar_Event(array(
        'summary' => 'Consulta Médica',
        'location' => 'Endereço da Clínica',
        'description' => 'Consulta com o Dr. Silva',
        'start' => array(
            'dateTime' => '2024-09-30T10:00:00-03:00',
            'timeZone' => 'America/Sao_Paulo',
        ),
        'end' => array(
            'dateTime' => '2024-09-30T11:00:00-03:00',
            'timeZone' => 'America/Sao_Paulo',
        ),
        'attendees' => array(
            array('email' => 'paciente@example.com'),
        ),
    ));

    // Adicionar o evento ao calendário
    $calendarId = 'primary';
    $event = $service->events->insert($calendarId, $event);

    echo 'Evento criado: ' . $event->htmlLink;
} else {
    // Redirecionar para a página de autenticação se não houver um token de acesso
    $authUrl = $client->createAuthUrl();
    header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
}
?>
