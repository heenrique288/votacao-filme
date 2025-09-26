<?php
session_start();
require "login/auth.php";
include "conexao.php";

$usuarioId = $_SESSION['usuario_id'] ?? 0;
if (!$usuarioId) {
    $_SESSION['mensagem'] = "Você precisa estar logado.";
    $_SESSION['tipo'] = "error";
    header("Location: login.php");
    exit;
}

// verificar admin
$stmt = $conn->prepare("SELECT admin FROM login WHERE id = ?");
$stmt->bind_param("i", $usuarioId);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows === 0) {
    $_SESSION['mensagem'] = "Usuário não encontrado.";
    $_SESSION['tipo'] = "error";
    header("Location: home.php");
    exit;
}
$row = $res->fetch_assoc();
if (intval($row['admin']) !== 1) {
    $_SESSION['mensagem'] = "Acesso negado: apenas admin pode finalizar a votação.";
    $_SESSION['tipo'] = "error";
    header("Location: home.php");
    exit;
}

// Se vier escolha manual (roleta), persiste o vencedor escolhido
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['choice']) && intval($_POST['choice']) > 0) {
    $choice = intval($_POST['choice']);

    // Buscar dados da indicacao para guardar título/poster
    $stmtI = $conn->prepare("SELECT titulo, poster_path FROM indicacoes WHERE id = ?");
    $stmtI->bind_param("i", $choice);
    $stmtI->execute();
    $resI = $stmtI->get_result();
    if ($resI->num_rows === 0) {
        $_SESSION['mensagem'] = "Indicação inválida.";
        $_SESSION['tipo'] = "error";
        header("Location: home.php");
        exit;
    }
    $ind = $resI->fetch_assoc();

    // Inserir em filme_semana
    $ins = $conn->prepare("INSERT INTO filme_semana (indicacao_id, titulo, poster_path) VALUES (?, ?, ?)");
    $ins->bind_param("iss", $choice, $ind['titulo'], $ind['poster_path']);
    $ins->execute();

    $_SESSION['mensagem'] = "Votação finalizada. Filme vencedor: " . $ind['titulo'];
    $_SESSION['tipo'] = "success";
    header("Location: home.php");
    exit;
}

// Apuração automática (quando o admin clicou no botão "Finalizar votação")
$sqlVotos = "SELECT indicacao_id, COUNT(*) as total FROM votos GROUP BY indicacao_id";
$resVotos = $conn->query($sqlVotos);

if (!$resVotos || $resVotos->num_rows === 0) {
    $_SESSION['mensagem'] = "Nenhum voto registrado.";
    $_SESSION['tipo'] = "error";
    header("Location: home.php");
    exit;
}

$votosArr = [];
$maxVotos = 0;
while ($r = $resVotos->fetch_assoc()) {
    $votosArr[intval($r['indicacao_id'])] = intval($r['total']);
    if ($r['total'] > $maxVotos) $maxVotos = intval($r['total']);
}

// pegar todos que tem total == maxVotos
$winners = [];
foreach ($votosArr as $id => $total) {
    if ($total === $maxVotos) $winners[] = $id;
}

if (count($winners) === 1) {
    // vencedor único -> persistir
    $winnerId = $winners[0];

    $stmtI = $conn->prepare("SELECT titulo, poster_path FROM indicacoes WHERE id = ?");
    $stmtI->bind_param("i", $winnerId);
    $stmtI->execute();
    $resI = $stmtI->get_result();
    $ind = $resI->fetch_assoc();

    $ins = $conn->prepare("INSERT INTO filme_semana (indicacao_id, titulo, poster_path) VALUES (?, ?, ?)");
    $ins->bind_param("iss", $winnerId, $ind['titulo'], $ind['poster_path']);
    $ins->execute();

    $_SESSION['mensagem'] = "Votação finalizada. Filme vencedor: " . $ind['titulo'];
    $_SESSION['tipo'] = "success";
    header("Location: home.php");
    exit;
} else {
    // empate -> redireciona para a página da roleta (ids separados por vírgula)
    $ids = implode(",", $winners);
    header("Location: roleta.php?ids=" . urlencode($ids));
    exit;
}
