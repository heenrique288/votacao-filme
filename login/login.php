<?php
session_start();
include("../conexao.php");

// Se já estiver logado, vai direto para home
if (isset($_SESSION['usuario_id'])) {
    header("Location: ../home.php");
    exit;
}

$erro = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT id, nome, senha, admin FROM login WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();

        if (password_verify($senha, $usuario['senha'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['admin'] = intval($usuario['admin']);

            header("Location: ../home.php");
            exit;
        } else {
            $erro = "Senha incorreta!";
        }
    } else {
        $erro = "Usuário não encontrado!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../src/css/login.css">
</head>
<body>
    
<div class="container">
    <h2>Login</h2>

    <?php if ($erro): ?>
        <p class="erro"><?= $erro ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="senha" placeholder="Senha" required><br>
        <button type="submit">Entrar</button>
    </form>
    <a href="register.php">Criar conta</a>
</div>