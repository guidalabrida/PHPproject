<?php
$conn = new mysqli('localhost', 'root', '', 'simples_login');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (username, email, password) VALUES ('$username', '$email', '$password')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Cadastro realizado com sucesso!";
    } else {
        echo "Erro ao cadastrar: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Cadastro</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Cadastro</h2>
        <form method="POST">
            <label for="username">Usuário:</label>
            <input type="text" id="username" name="username" required><br><br>
            
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required><br><br>
            
            <label for="password">Senha:</label>
            <input type="password" id="password" name="password" required><br><br>
            <input type="submit" value="Cadastrar">
        </form>
        <p>Já tem uma conta? <a href="index.php">Faça login aqui</a></p>
    </div>
</body>
</html>
