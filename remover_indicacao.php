<?php 
include("conexao.php");
session_start();

if (isset($_POST['indicacao_id'])) {
    $id = intval($_POST['indicacao_id']); // intval para evitar SQL Injection

     // 1. Deletar os votos relacionados
    $sqlVotos = "DELETE FROM votos WHERE indicacao_id = $id";
    $conn->query($sqlVotos);

    // 2. Deletar a indicação
    $sqlIndicacao = "DELETE FROM indicacoes WHERE id = $id";
    
    if ($conn->query($sqlIndicacao) === TRUE) {
        // 4. Redirecionar para a página principal ou lista
        $_SESSION['mensagem'] = "Filme removido com sucesso.";
        $_SESSION['tipo'] = "success";
    } else {
        $_SESSION['mensagem'] = "Filme removido com sucesso.";
        $_SESSION['tipo'] = "error";
    }

    header("Location: home.php");
    exit;
} else {
    $_SESSION['mensagem'] = "Filme removido com sucesso.";
    $_SESSION['tipo'] = "error";
    header("Location: home.php");
    exit;
}