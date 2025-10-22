<?php 
include 'conexao.php';
require "login/auth.php";

$apiKey = "76aa3e8d299c64cc616c04567e05a080"; // coloque sua chave TMDB
$query = isset($_GET['q']) ? urlencode($_GET['q']) : '';
$results = [];

if ($query) {
    $url = "https://api.themoviedb.org/3/search/movie?api_key={$apiKey}&language=pt-BR&query={$query}";
    $response = file_get_contents($url);
    $results = json_decode($response, true);
}
?>
<?php include("global/header.php"); ?>
<main>
    <section class="search-section py-5 bg-light">
        <div class="container text-center">
            <h1 class="mb-4">Encontre seu Filme</h1>
            <form class="d-flex justify-content-center" action="" method="GET">
                <input class="form-control form-control-lg me-2 rounded-pill shadow-sm" 
                        type="search" name="q" placeholder="Pesquisar filmes..." aria-label="Pesquisar" 
                        style="max-width: 500px;" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
                <button class="btn btn-primary btn-lg rounded-pill shadow-sm" type="submit">Buscar</button>
            </form>
        </div>
    </section>

    <!-- Resultados -->
    <div class="container mt-5">
        <?php if ($query): ?>
            <h2 class="mb-4">Resultados da busca por "<?= htmlspecialchars($_GET['q']) ?>"</h2>
            <div class="row">
                <?php if (!empty($results['results'])): ?>
                    <?php foreach ($results['results'] as $filme): ?>
                        <div class="col-6 col-md-3 mb-4">
                            <div class="card h-100 shadow-sm">
                                <?php if ($filme['poster_path']): ?>
                                    <a href="abrirfilme.php?id=<?= $filme['id'] ?>">
                                        <img src="https://image.tmdb.org/t/p/w500<?= $filme['poster_path'] ?>"
                                                class="card-img-top" alt="<?= htmlspecialchars($filme['title']) ?>">
                                    </a>
                                <?php else: ?>
                                    <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height:400px;">
                                        Sem imagem
                                    </div>
                                <?php endif; ?>
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($filme['title']) ?></h5>
                                    <p class="card-text"><?= htmlspecialchars($filme['release_date'] ?? 'Ano desconhecido') ?></p>
                                    <p class="card-text text-truncate"><?= htmlspecialchars($filme['overview']) ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Nenhum resultado encontrado.</p>
                <?php endif; ?>
            </div>
        <?php else: ?>
        <?php endif; ?>
    </div>
</main>
<?php include("global/footer.php"); ?>
