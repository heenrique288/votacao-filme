<?php
require "conexao.php";
header("Content-Type: application/json; charset=utf-8");

// Busca o status atual da roleta na tabela status_votacao
$res = $conn->query("SELECT resultado, roleta_ativa FROM status_votacao LIMIT 1");
$row = $res->fetch_assoc();

echo json_encode([
    "resultado" => $row['resultado'] ?? null,
    "poster_path" => $row['poster_path'] ?? null,
    "girando"   => isset($row['roleta_ativa']) ? intval($row['roleta_ativa']) : 0
]);
