<?php
include("../conexao.php");

$erro = "";
$sucesso = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    $sql = "INSERT INTO login (nome, sobrenome, email, senha) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nome, $sobrenome, $email, $senhaHash);

    try {
        $stmt->execute();
        $sucesso = "Usuário registrado com sucesso! <a href='login.php'>Ir para login</a>";
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            $erro = "Já existe um usuário com este e-mail!";
        } else {
            $erro = "Erro: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="../src/css/register.css">
</head>
<body>

<div class="container">
    <h2>Registro</h2>

    <?php if ($erro): ?>
        <p class="erro"><?= $erro ?></p>
    <?php endif; ?>

    <?php if ($sucesso): ?>
        <p class="sucesso"><?= $sucesso ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="text" name="nome" placeholder="Nome" required><br>
        <input type="text" name="sobrenome" placeholder="Sobrenome" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="senha" placeholder="Senha" required><br>
        <button type="submit">Cadastrar</button>
    </form>
    <a href="login.php">Já tenho conta</a>
</div>

<?php include("../global/footer.php"); ?>