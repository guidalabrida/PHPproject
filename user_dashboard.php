<?php
session_start();

// Verifica se o usuário está logado e é um usuário comum
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'user') {
    header("Location: index.php"); // Redireciona para a página de login se não estiver autenticado
    exit();
}

$username = $_SESSION['username'];

// Conecta ao banco de dados
$conn = new mysqli('localhost', 'root', '', 'simples_login');

// Verifica se houve erro na conexão com o banco de dados
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Busca as consultas do usuário (exemplo; ajuste conforme sua tabela de consultas)
$sql = "SELECT * FROM consultas WHERE username='$username'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Usuário</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Painel do Usuário</h2>
        <p>Bem-vindo, <?php echo htmlspecialchars($username); ?>!</p>

        <!-- Se você tiver um sistema de agendamento de consultas -->
        <h3>Minhas Consultas</h3>
        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Data</th>
                        <th>Hora</th>
                        <th>Médico</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['data']); ?></td>
                            <td><?php echo htmlspecialchars($row['hora']); ?></td>
                            <td><?php echo htmlspecialchars($row['medico']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Você ainda não tem consultas agendadas.</p>
        <?php endif; ?>

        <a href="logout.php">Sair</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>
