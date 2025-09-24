<?php
session_start();
require "login/auth.php";
include "conexao.php";

$apiKey = "76aa3e8d299c64cc616c04567e05a080"; 
$filme = null;
$indicacao = null;
$diretor = "Desconhecido";

// Caso seja para ver uma indicação
$indicacaoId = isset($_GET['indicacao']) ? intval($_GET['indicacao']) : 0;

// Caso seja para ver detalhes de um filme da busca
$filmeId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($indicacaoId > 0) {
    // Busca dados da indicação no banco
    $stmt = $conn->prepare("SELECT i.*, l.nome, l.foto 
                            FROM indicacoes i
                            JOIN login l ON i.usuario_id = l.id
                            WHERE i.id = ?");
    $stmt->bind_param("i", $indicacaoId);
    $stmt->execute();
    $result = $stmt->get_result();
    $indicacao = $result->fetch_assoc();

    if ($indicacao) {
        $filmeId = $indicacao['filme_id'];
    }
}

// Se temos um filmeId (seja da busca ou de uma indicação), buscamos os dados na API
if ($filmeId > 0) {
    // Detalhes do filme
    $url = "https://api.themoviedb.org/3/movie/{$filmeId}?api_key={$apiKey}&language=pt-BR";
    $response = file_get_contents($url);
    $filme = json_decode($response, true);

    // Créditos (para pegar diretor, elenco etc.)
    $creditsUrl = "https://api.themoviedb.org/3/movie/{$filmeId}/credits?api_key={$apiKey}&language=pt-BR";
    $creditsResponse = file_get_contents($creditsUrl);
    $credits = json_decode($creditsResponse, true);

    if (!empty($credits['crew'])) {
        foreach ($credits['crew'] as $pessoa) {
            if ($pessoa['job'] === "Director") {
                $diretor = $pessoa['name'];
                break;
            }
        }
    }
}
?>

<?php include("global/header.php"); ?>

<div class="container py-5">

    <?php if ($filme): ?>
        <!-- Banner -->
        <?php if (!empty($filme['backdrop_path'])): ?>
            <img src="https://image.tmdb.org/t/p/w1280<?= $filme['backdrop_path'] ?>" 
                 class="img-fluid rounded mb-4 shadow">
        <?php endif; ?>

        <!-- Detalhes -->
        <h1 class="mb-3"><?= htmlspecialchars($filme['title']) ?></h1>
        <p><strong>Diretor:</strong> <?= htmlspecialchars($diretor) ?></p>
        <p><strong>Data de lançamento:</strong> <?= htmlspecialchars($filme['release_date']) ?></p>
        <p><strong>Sinopse:</strong> <?= htmlspecialchars($filme['overview']) ?></p>

        <?php if ($indicacao): ?>
            <!-- Usuário que indicou -->
            <div class="d-flex align-items-center mt-4 mb-3">
                <?php if (!empty($indicacao['foto'])): ?>
                    <img src="uploads/<?= htmlspecialchars($indicacao['foto']) ?>" 
                         class="rounded-circle me-2" 
                         width="50" height="50" alt="Foto de <?= htmlspecialchars($indicacao['nome']) ?>">
                <?php else: ?>
                    <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-2" 
                         style="width:50px; height:50px;">?</div>
                <?php endif; ?>
                <span>Indicado por <strong><?= htmlspecialchars($indicacao['nome']) ?></strong></span>
            </div>
        <?php else: ?>
            <!-- Botão indicar apenas se não for uma indicação já existente -->
            <a href="indicar.php?id=<?= $filme['id'] ?>" class="btn btn-primary btn-lg mt-3">Indicar Filme</a>
        <?php endif; ?>

    <?php else: ?>
        <p>Filme não encontrado.</p>
    <?php endif; ?>

</div>

<?php include("global/footer.php"); ?>
