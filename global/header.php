<?php 
include __DIR__ . "/../conexao.php";      
require __DIR__ . "/../login/auth.php";

$usuario_id = $_SESSION['usuario_id'] ?? null;
$user_foto = null;

if ($usuario_id) {
    $sql = "SELECT foto FROM login WHERE id = $usuario_id";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();
    $user_foto = $user['foto'] ?? null;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To zuando</title>
    <link rel="stylesheet" href="/votacao-filme/src/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="/votacao-filme/src/js/index.js" defer></script>
</head>
<body>
<header>
    <div class="logo">
        <h2>To zuando</h2>
    </div>
    <ul>
        <li><a href="/votacao-filme/home.php">Home</a></li>
        <li><a href="/votacao-filme/sobre.php">Sobre</a></li>
        <li><a href="/votacao-filme/index.php">Indique seu filme!</a></li>
        <li><a href="#">Tabela de filmes</a></li>
    </ul>
    <div class="perfil">
        <?php if (!$user_foto): ?>
            <!-- Ícone se não houver foto -->
            <i class="fa-solid fa-user-circle" id="perfilIcon"></i>
        <?php else: ?>
            <!-- Foto do usuário -->
            <img src="/votacao-filme/uploads/<?= $user_foto ?>" alt="Foto de perfil" class="user-photo" id="perfilIcon">
        <?php endif; ?>
        <div class="dropdown" id="dropdownMenu">
            <a href="/votacao-filme/dropdown/perfil.php">Perfil</a>
            <a href="meusfilmes.php">Meus filmes</a>
            <a href="temas.php">Temas</a>
            <a href="configuracoes.php">Configurações</a>
            <a href="/votacao-filme/login/logout.php">Sair</a>
        </div>
    </div>
</header>
