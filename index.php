<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'simples_login');

// Verifica se houve erro na conexão com o banco de dados
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Consulta o usuário no banco de dados
    $sql = "SELECT * FROM usuarios WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verifica a senha
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $user['role']; // Armazena o tipo de usuário

            // Verifica o tipo de usuário (admin ou user)
            if ($user['role'] == 'admin') {
                header("Location: admin_dashboard.php"); // Redireciona para o painel do admin
            } else {
                header("Location: user_dashboard.php"); // Redireciona para o painel do usuário comum
            }
            exit();
        } else {
            echo "Senha incorreta!";
        }
    } else {
        echo "Usuário não encontrado!";
    }
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form method="POST" action="">
            <label for="username">Usuário:</label>
            <input type="text" id="username" name="username" required><br><br>
            <label for="password">Senha:</label>
            <input type="password" id="password" name="password" required><br><br>
            <input type="submit" value="Login">
        </form>
        <p>Não tem uma conta? <a href="register.php">Cadastre-se aqui</a></p>
    </div>
</body>
</html>

