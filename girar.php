<?php
session_start();
require "conexao.php";
header("Content-Type: application/json; charset=utf-8");

try {
    // Só admin pode girar
    if (!isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
        echo json_encode(["sucesso" => false, "erro" => "Apenas admin pode girar"]);
        exit;
    }

    // Recebe candidatos
    $candidates = $_POST['candidates'] ?? '';
    $candidatesArr = json_decode($candidates, true);

    if (!$candidatesArr || !is_array($candidatesArr)) {
        echo json_encode(["sucesso" => false, "erro" => "Nenhum candidato recebido"]);
        exit;
    }

    // Escolhe aleatório
    $chosen = $candidatesArr[array_rand($candidatesArr)];

    
    // Garante que exista pelo menos um registro
    $conn->query("INSERT INTO status_votacao (roleta_ativa, resultado) 
                SELECT 0, NULL 
                WHERE NOT EXISTS (SELECT 1 FROM status_votacao)");

    $poster = $chosen['poster_path'] ?? null;

    // Atualiza status_votacao (em vez de status_roleta)
    $stmt = $conn->prepare("
        UPDATE status_votacao 
        SET resultado = ?, poster_path=?, roleta_ativa = 1 
        LIMIT 1
    ");

    $stmt->bind_param("ss", $chosen['titulo'], $poster);
    $stmt->execute();

    echo json_encode([
        "sucesso" => true,
        "resultado" => $chosen['titulo'],
        "poster_path" => $chosen['poster_path'] ? "https://image.tmdb.org/t/p/w342".$chosen['poster_path'] : null,
        "girando" => 1
    ]);

} catch (Exception $e) {
    echo json_encode(["sucesso" => false, "erro" => $e->getMessage()]);
}
