<?php
require 'google-calendar-setup.php';

// Autenticar o cliente
$client = getClient();
$service = new Google_Service_Calendar($client);

// ID do calendário principal
$calendarId = 'primary';

// Dados do evento de consulta
$event = new Google_Service_Calendar_Event(array(
  'summary' => 'Consulta Médica',
  'location' => 'Clinica XYZ, Rua ABC, Cidade',
  'description' => 'Consulta com o Dr. Fulano',
  'start' => array(
    'dateTime' => '2024-09-30T10:00:00-03:00',
    'timeZone' => 'America/Sao_Paulo',
  ),
  'end' => array(
    'dateTime' => '2024-09-30T11:00:00-03:00',
    'timeZone' => 'America/Sao_Paulo',
  ),
  'attendees' => array(
    array('email' => 'paciente@email.com'),
  ),
  'reminders' => array(
    'useDefault' => false,
    'overrides' => array(
      array('method' => 'email', 'minutes' => 24 * 60),
      array('method' => 'popup', 'minutes' => 10),
    ),
  ),
));

// Inserir evento no Google Calendar
$event = $service->events->insert($calendarId, $event);
printf('Evento criado: %s\n', $event->htmlLink);
