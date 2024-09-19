<?php
session_start();
require 'vendor/autoload.php'; // Certifique-se de que o autoload está corretamente incluído

use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;

$conn = new mysqli('localhost', 'root', '', 'simples_login');

// Verificar a conexão com o banco de dados
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Configurar o cliente da API do Google
$client = new Client();
$client->setAuthConfig('credentials.json'); // O arquivo JSON baixado do Console de Desenvolvedor
$client->addScope(Calendar::CALENDAR);
$service = new Calendar($client);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtendo os valores do formulário
    $data = isset($_POST['data']) ? $_POST['data'] : '';
    $hora_inicio = isset($_POST['hora_inicio']) ? $_POST['hora_inicio'] : '';
    $hora_fim = isset($_POST['hora_fim']) ? $_POST['hora_fim'] : '';

    // Verificar se os campos estão preenchidos
    if ($data && $hora_inicio && $hora_fim) {
        // Preparar e executar a consulta SQL para inserir os dados
        $stmt = $conn->prepare("INSERT INTO horarios (data, hora_inicio, hora_fim) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $data, $hora_inicio, $hora_fim);

        if ($stmt->execute()) {
            // Criação do evento no Google Calendar
            $event = new Event([
                'summary' => 'Consulta Médica',
                'start' => [
                    'dateTime' => "$dataT$hora_inicio:00",
                    'timeZone' => 'America/Sao_Paulo',
                ],
                'end' => [
                    'dateTime' => "$dataT$hora_fim:00",
                    'timeZone' => 'America/Sao_Paulo',
                ],
                'attendees' => [
                    ['email' => 'usuario@example.com'], // Substitua pelo e-mail do usuário
                ],
            ]);

            $calendarId = 'primary'; // ID do calendário. Use 'primary' para o calendário principal.
            $result = $service->events->insert($calendarId, $event);

            echo "Horário adicionado com sucesso! Evento criado no Google Calendar.";
        } else {
            echo "Erro ao adicionar horário: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Por favor, preencha todos os campos.";
    }
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Horário</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Adicionar Horário</h2>
        <form method="POST" action="adicionar_horario.php">
            <label for="data">Data:</label>
            <input type="date" id="data" name="data" required><br><br>

            <label for="hora_inicio">Hora de Início:</label>
            <input type="time" id="hora_inicio" name="hora_inicio" required><br><br>

            <label for="hora_fim">Hora de Fim:</label>
            <input type="time" id="hora_fim" name="hora_fim" required><br><br>

            <input type="submit" value="Adicionar Horário">
        </form>
    </div>
</body>
</html>
