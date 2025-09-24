<?php
session_start();
require "login/auth.php"; // garante que só logado indica
include "conexao.php";

$apiKey = "76aa3e8d299c64cc616c04567e05a080";
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$usuarioId = $_SESSION['usuario_id']; // assumindo que você guarda o id do usuário na sessão

if ($id > 0 && $usuarioId) {
    // 1️⃣ Verifica se o usuário já indicou algum filme
    $checkUser = $conn->prepare("SELECT id FROM indicacoes WHERE usuario_id = ?");
    $checkUser->bind_param("i", $usuarioId);
    $checkUser->execute();
    $resUser = $checkUser->get_result();

    if ($resUser->num_rows > 0) {
        $_SESSION['mensagem'] = "Você já indicou um filme. Só é permitido 1 por usuário.";
        $_SESSION['tipo'] = "error";
        header ("Location: home.php");
        exit;
    }

    // 2️⃣ Verifica se esse filme já foi indicado por outro usuário
    $checkFilme = $conn->prepare("SELECT id FROM indicacoes WHERE filme_id = ?");
    $checkFilme->bind_param("i", $id);
    $checkFilme->execute();
    $resFilme = $checkFilme->get_result();

    if ($resFilme->num_rows > 0) {
        $_SESSION['mensagem'] = "Esse filme já foi indicado por outro usuário.";
        $_SESSION['tipo'] = "error";
        header("Location: home.php");
        exit;
    }

    // Buscar os dados do filme
    $url = "https://api.themoviedb.org/3/movie/{$id}?api_key={$apiKey}&language=pt-BR";
    $response = file_get_contents($url);
    $filme = json_decode($response, true);

    if ($filme) {
        $titulo = $conn->real_escape_string($filme['title']);
        $poster = $conn->real_escape_string($filme['poster_path'] ?? '');
        $backdrop = $conn->real_escape_string($filme['backdrop_path'] ?? '');
        $overview = $conn->real_escape_string($filme['overview'] ?? '');

        // Inserir no banco
        $sql = "INSERT INTO indicacoes (usuario_id, filme_id, titulo, poster_path, backdrop_path, overview)
                VALUES ('$usuarioId', '{$id}', '$titulo', '$poster', '$backdrop', '$overview')";

        if ($conn->query($sql)) {
            $_SESSION['mensagem'] = "Filme indicado com sucesso!";
            $_SESSION['tipo'] = "success";
            header("Location: home.php");
            exit;
        } else {
            $_SESSION['mensagem'] = "Erro ao salvar: " . $conn->error;
            $_SESSION['tipo'] = "error";
            header("Location: home.php");
            exit;
        }
    }
} else {
    $_SESSION['mensagem'] = "ID do filme inválido.";
    $_SESSION['tipo'] = "error";
    header("Location: home.php");
    exit;
}