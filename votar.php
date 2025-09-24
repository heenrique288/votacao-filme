<?php
session_start();
require "login/auth.php";
include "conexao.php";

$usuarioId = $_SESSION['usuario_id'];
$indicacaoId = isset($_POST['indicacao_id']) ? intval($_POST['indicacao_id']) : 0;

// Impede votar no próprio filme
$check = $conn->prepare("SELECT id FROM indicacoes WHERE id = ? AND usuario_id = ?");
$check->bind_param("ii", $indicacaoId, $usuarioId);
$check->execute();
$res = $check->get_result();
if ($res->num_rows > 0) {
    $_SESSION['mensagem'] = "Você não pode votar no filme que indicou.";
    $_SESSION['tipo'] = "error";
    header("Location: home.php");
    exit;
}

// Verifica se já existe voto
$checkVoto = $conn->prepare("SELECT id FROM votos WHERE usuario_id = ?");
$checkVoto->bind_param("i", $usuarioId);
$checkVoto->execute();
$resVoto = $checkVoto->get_result();

if ($resVoto->num_rows > 0) {
    // Atualiza o voto
    $update = $conn->prepare("UPDATE votos SET indicacao_id = ? WHERE usuario_id = ?");
    $update->bind_param("ii", $indicacaoId, $usuarioId);
    $update->execute();
} else {
    // Insere novo voto
    $insert = $conn->prepare("INSERT INTO votos (usuario_id, indicacao_id) VALUES (?, ?)");
    $insert->bind_param("ii", $usuarioId, $indicacaoId);
    $insert->execute();
}

$_SESSION['mensagem'] = "Seu voto foi registrado!";
$_SESSION['tipo'] = "success";
header("Location: home.php");
exit;
