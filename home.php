<?php
include("global/header.php");
require "login/auth.php";
include("conexao.php");

// Buscar filmes indicados + usuário
$sql = "SELECT i.*, l.nome, l.foto
        FROM indicacoes i
        JOIN login l ON i.usuario_id = l.id
        ORDER BY i.data_indicacao DESC";
$result = $conn->query($sql);

$mensagem = '';
$tipo = '';

if (isset($_SESSION['mensagem'])) {
    $mensagem = $_SESSION['mensagem'];
    $tipo = $_SESSION['tipo'] ?? 'success';
    unset($_SESSION['mensagem']);
    unset($_SESSION['tipo']);
}

// Buscar votos
$sqlVotos = "SELECT indicacao_id, COUNT(*) as total 
             FROM votos GROUP BY indicacao_id";
$resVotos = $conn->query($sqlVotos);

$votosPorFilme = [];
$maxVotos = 0;
while ($row = $resVotos->fetch_assoc()) {
    $votosPorFilme[$row['indicacao_id']] = $row['total'];
    if ($row['total'] > $maxVotos) {
        $maxVotos = $row['total'];
    }
}

$usuarioId = $_SESSION['usuario_id'] ?? 0;

$nomeCompleto = "Usuário"; // valor padrão caso não encontre no banco

if ($usuarioId) {
    $sql = "SELECT nome, sobrenome FROM login WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuarioId);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows > 0) {
        $user = $res->fetch_assoc();
        $nomeCompleto = $user['nome'] . ' ' . $user['sobrenome'];
    }
}
?>

<link rel="stylesheet" href="src/css/home.css">

<div id="toast" class="<?= $tipo ?>" style="display:none;">
    <?= $mensagem ?>
</div>

<div class="home-page">
    <div class="container">
        <h1>🍿 Bem-vindo <?= htmlspecialchars($nomeCompleto) ?> ao TO ZUANDO!</h1>
        <p>
            Aqui a mágica do cinema acontece de um jeito diferente:  
            toda semana, cada um indica um filme que ninguém viu,  
            todos votamos pela sinopse, e o grande vencedor se torna  
            o <strong>Filme da Semana</strong>! 🎬  
            Depois assistimos juntos e gravamos um podcast comentando no YouTube.
        </p>
    </div>
</div>

<section class="indicacoes">
    <div class="container">
        <h2 class="titulo-secundario">🎥 Filmes Indicados</h2>

        <?php if ($result->num_rows > 0): ?>
            <div class="lista-filmes">
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="card-filme-container">
                        <a href="abrirfilme.php?indicacao=<?= $row['id'] ?>" class="card-filme">
                            <?php if ($row['backdrop_path']): ?>
                                <img src="https://image.tmdb.org/t/p/w780<?= $row['backdrop_path'] ?>" alt="<?= htmlspecialchars($row['titulo']) ?>">
                            <?php else: ?>
                                <div class="sem-imagem">Sem imagem</div>
                            <?php endif; ?>
                            <div class="info-filme">
                                <h3><?= htmlspecialchars($row['titulo']) ?></h3>
                                <p><?= htmlspecialchars($row['overview']) ?></p>
                                <div class="usuario">
                                    <?php if ($row['foto']): ?>
                                        <img src="uploads/<?= htmlspecialchars($row['foto']) ?>" alt="Foto de <?= htmlspecialchars($row['nome']) ?>" class="foto-perfil">
                                    <?php else: ?>
                                        <i class="fa-solid fa-user-circle" id="perfilIcon"></i>
                                    <?php endif; ?>
                                    <span>Indicado por <strong><?= htmlspecialchars($row['nome']) ?></strong></span>
                                </div>
                            </div>
                        </a>
                        <?php
                        // ---- Parte dos votos dentro do loop ----
                        $idIndicacao = $row['id'];
                        $totalVotos = $votosPorFilme[$idIndicacao] ?? 0;
                        $percent = $maxVotos > 0 ? ($totalVotos / $maxVotos) * 100 : 0;
                        // Busca até 3 avatares
                        $sqlAvatares = $conn->prepare("SELECT l.foto
                                                       FROM votos v
                                                       JOIN login l ON v.usuario_id = l.id
                                                       WHERE v.indicacao_id = ?
                                                       LIMIT 3");
                        $sqlAvatares->bind_param("i", $idIndicacao);
                        $sqlAvatares->execute();
                        $resAvatares = $sqlAvatares->get_result();
                        ?>
                        <div class="card-footer">
                            <form method="POST" action="votar.php">
                                <input type="hidden" name="indicacao_id" value="<?= $idIndicacao ?>">
                                <button type="submit" class="btn btn-outline-primary btn-sm">Votar</button>
                            </form>
                            <div class="progress mt-2" style="height: 20px;">
                                <div class="progress-bar" role="progressbar"
                                    style="width: <?= $percent ?>%;"
                                    aria-valuenow="<?= $percent ?>" aria-valuemin="0" aria-valuemax="100">
                                    <?= $totalVotos ?> votos
                                </div>
                            </div>
                            <div class="d-flex mt-2">
                                <?php while ($avatar = $resAvatares->fetch_assoc()): ?>
                                    <?php if (!empty($avatar['foto'])): ?>
                                        <img src="uploads/<?= htmlspecialchars($avatar['foto']) ?>"
                                            class="rounded-circle me-1" width="30" height="30">
                                    <?php else: ?>
                                        <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-1"
                                            style="width:30px; height:30px;">?</div>
                                    <?php endif; ?>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    </div>
                    <!-- ---- fim parte dos votos ---- -->

                <?php endwhile; ?>
            </div>

            <!-- ---- Mostrar todos os votos ---- -->
            <!-- Botão -->
            <button class="btn btn-outline-primary mt-4" type="button" data-bs-toggle="collapse" data-bs-target="#todosVotos">
                Mostrar votos
            </button>

            <div class="collapse mt-2" id="todosVotos">
                <div class="card card-body votos-card">
                    <?php
                    $sqlDetalhe = "SELECT i.titulo, l.nome, l.foto
                                FROM votos v
                                JOIN indicacoes i ON v.indicacao_id = i.id
                                JOIN login l ON v.usuario_id = l.id
                                ORDER BY i.titulo";
                    $resDetalhe = $conn->query($sqlDetalhe);
                    $votosDetalhe = [];
                    while ($row = $resDetalhe->fetch_assoc()) {
                        $votosDetalhe[$row['titulo']][] = $row; // guarda nome e foto
                    }
                    ?>

                    <?php foreach ($votosDetalhe as $filme => $usuarios): ?>
                        <div class="mb-3">
                            <h5 class="mb-2">🎬 <?= htmlspecialchars($filme) ?></h5>
                            <?php foreach ($usuarios as $u): ?>
                                <div class="d-flex align-items-center mb-2">
                                    <?php if (!empty($u['foto'])): ?>
                                        <img src="uploads/<?= htmlspecialchars($u['foto']) ?>" 
                                            class="rounded-circle me-2 d-flex" width="30" height="30" alt="foto de <?= htmlspecialchars($u['nome']) ?>">
                                    <?php else: ?>
                                        <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-2"
                                            style="width:30px; height:30px;">?</div>
                                    <?php endif; ?>
                                    <span><?= htmlspecialchars($u['nome']) ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- ---- fim mostrar todos os votos ---- -->

        <?php else: ?>
            <p class="sem-filmes">Nenhum filme foi indicado ainda! Indique um filme para começar! 🎬</p>
        <?php endif; ?>
    </div>
</section>

<script src="src/js/perfil.js"></script>

<?php include("global/footer.php"); ?>
