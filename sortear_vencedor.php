<?php
require "conexao.php";
header("Content-Type: application/json");

$ids = explode(",", $_GET['ids'] ?? '');
if (empty($ids)) {
    echo json_encode(["error" => "Nenhum ID recebido."]);
    exit;
}

// Escolhe aleatoriamente um vencedor
$chosen = $ids[array_rand($ids)];

// Busca dados do filme
$stmt = $conn->prepare("SELECT titulo, poster_path FROM indicacoes WHERE id = ?");
$stmt->bind_param("i", $chosen);
$stmt->execute();
$res = $stmt->get_result();
$filme = $res->fetch_assoc();

// Atualiza status_votacao
$conn->query("DELETE FROM status_votacao");
$stmt2 = $conn->prepare("INSERT INTO status_votacao (resultado, poster_path, roleta_ativa) VALUES (?, ?, 1)");
$stmt2->bind_param("is", $chosen, $filme['poster_path']);
$stmt2->execute();

echo json_encode([
    "id" => $chosen,
    "titulo" => $filme['titulo'],
    "poster_path" => $filme['poster_path']
]);
