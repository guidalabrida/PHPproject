<?php
session_start();
include 'conexao.php'; // Incluindo a conexão com o banco de dados

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    echo "Acesso negado!";
    exit;
}

// Código para adicionar/remover horários
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styleadm.css">
</head>
<body>
    <h1>Gerenciar Horários</h1>
    
    <h2>Adicionar Novo Horário</h2>
    <form action="adicionar_horario.php" method="POST">
        <label for="data">Data:</label>
        <input type="date" name="data" required><br>

        <label for="hora">Hora:</label>
        <input type="time" name="hora" required><br>

        <input type="submit" value="Adicionar Horário">
    </form>

    <h2>Horários Atuais</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Data</th>
            <th>Hora</th>
            <th>Ação</th>
        </tr>
        <?php
        // Exibir todos os horários disponíveis
        include('conexao.php');
        $sql = "SELECT * FROM horarios";
        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['data'] . "</td>";
            echo "<td>" . $row['hora'] . "</td>";
            echo "<td><a href='remover_horario.php?id=" . $row['id'] . "'>Remover</a></td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>
