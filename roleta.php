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

// ids vindos por GET (ex: 5,7)
$idsParam = $_GET['ids'] ?? '';
$idsClean = preg_replace('/[^0-9,]/', '', $idsParam);
if (empty($idsClean)) {
    $_SESSION['mensagem'] = "Sem candidatos para desempate.";
    $_SESSION['tipo'] = "error";
    header("Location: home.php");
    exit;
}

$sql = "SELECT id, titulo, poster_path FROM indicacoes WHERE id IN ($idsClean)";
$resI = $conn->query($sql);
$candidates = [];
while ($r = $resI->fetch_assoc()) {
    $candidates[] = $r;
}
if (count($candidates) < 2) {
    $_SESSION['mensagem'] = "Não há empate válido.";
    $_SESSION['tipo'] = "error";
    header("Location: home.php");
    exit;
}
?>
<?php include("global/header.php"); ?>

<div class="container py-5">
    <h2>🌀 Roleta de Desempate</h2>
    <p>Existem <?= count($candidates) ?> filmes empatados. Clique em <strong>Girar roleta</strong> para escolher o vencedor.</p>

    <div id="roletaBox" class="my-4" style="text-align:center;">
        <div id="cartaz" style="max-width:320px; margin:0 auto;">
            <!-- imagem do candidato atual -->
        </div>
        <h3 id="nomeFilme" class="mt-3"></h3>
    </div>

    <div class="text-center mb-4">
        <?php
            // Verifica se usuário é admin
            $isAdmin = (isset($_SESSION['admin']) && $_SESSION['admin'] == 1);
        ?>
        <button id="spinBtn" class="btn btn-primary btn-lg" <?php if (!$isAdmin) echo 'disabled'; ?>>Girar roleta</button>
    </div>

    <div class="text-center">
        <a href="home.php" class="btn btn-secondary <?php if (!$isAdmin) echo 'disabled'; ?>">Cancelar</a>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
const candidates = <?= json_encode($candidates, JSON_HEX_TAG) ?>;
const nomeFilme = document.getElementById('nomeFilme');
const cartaz = document.getElementById('cartaz');
const spinBtn = document.getElementById('spinBtn');

let running = false;
let resultadoFinal = null;
let mostrouResultado = false;

// mostra candidato
function showCandidate(idx) {
    const c = candidates[idx];
    nomeFilme.textContent = c.titulo;
    if (c.poster_path) {
        cartaz.innerHTML = `<img src="https://image.tmdb.org/t/p/w342${c.poster_path}" alt="${c.titulo}" class="img-fluid rounded shadow">`;
    } else {
        cartaz.innerHTML = `<div class="bg-secondary text-white p-5">Sem imagem</div>`;
    }
}

// animação com desaceleração
function spinV2(fixedIndex = null, isAdmin = false) {
    if (running) return;
    running = true;
    spinBtn.disabled = true;

    const totalSteps = 60 + Math.floor(Math.random() * 40);
    let step = 0, idx = 0;

    function stepFn() {
        const displayIdx = (fixedIndex !== null && step >= totalSteps) ? fixedIndex : idx % candidates.length;
        showCandidate(displayIdx);
        idx++;
        step++;

        let delay = 30 + Math.floor(Math.pow(step / totalSteps, 2) * 400);

        if (step < totalSteps) {
            setTimeout(stepFn, delay);
        } else {
            running = false;
            spinBtn.disabled = false;

            if (fixedIndex === null && isAdmin) {
                // admin confirma escolha
                const chosen = candidates[(idx - 1) % candidates.length];
                setTimeout(() => {
                    if (confirm('Confirmar vencedor: ' + chosen.titulo + ' ?')) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = 'finalizar_votacao.php';
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'choice';
                        input.value = chosen.id;
                        form.appendChild(input);
                        document.body.appendChild(form);
                        form.submit();
                    }
                }, 100); // pequeno delay para garantir execução
            } else if (fixedIndex !== null && !mostrouResultado) {
                spinBtn.disabled = true;
                mostrouResultado = true;
                const chosen = candidates[fixedIndex];

                nomeFilme.textContent = "🎬 " + chosen.titulo;
                if (chosen.poster_path) {
                    cartaz.innerHTML = `<img src="https://image.tmdb.org/t/p/w342${chosen.poster_path}" class="img-fluid rounded shadow">`;
                } else {
                    cartaz.innerHTML = `<div class="bg-secondary text-white p-5">Sem imagem</div>`;
                }

                // Se for admin, pergunta se quer confirmar o vencedor
                if (isAdmin) {
                    setTimeout(() => {
                        if (confirm('Confirmar vencedor: ' + chosen.titulo + ' ?')) {
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = 'finalizar_votacao.php';
                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = 'choice';
                            input.value = chosen.id;
                            form.appendChild(input);
                            document.body.appendChild(form);
                            form.submit();
                        }
                        else {
                            spinBtn.disabled = false;
                        }
                    }, 500); // pequeno delay para não interromper a animação
                }
            }
        }
    }

    stepFn();
}

// mostra primeiro candidato
showCandidate(0);

// admin: inicia roleta no clique
spinBtn.addEventListener('click', async () => {
    if (!<?= $isAdmin ? 'true' : 'false' ?>) return;
    mostrouResultado = false;

    // pega IDs dos candidatos (os empatados)
    const ids = candidates.map(c => c.id).join(',');

    try {
        // chama o backend para escolher o vencedor e salvar no banco
        const res = await fetch(`sortear_vencedor.php?ids=${ids}`);
        const data = await res.json();

        if (data.error) {
            alert("Erro: " + data.error);
            return;
        }

        // obtém o índice do vencedor no array local
        const winnerIndex = candidates.findIndex(c => c.id == data.id);

        if (winnerIndex === -1) {
            alert("Filme vencedor não encontrado entre os candidatos locais!");
            return;
        }

        // inicia a animação sincronizada
        spinV2(winnerIndex, true);

    } catch (e) {
        console.error(e);
        alert("Erro ao sortear o vencedor.");
    }
});

// polling para todos
setInterval(() => {
    $.get("status_roleta.php", function(res){
        if(res.resultado){
            resultadoFinal = candidates.findIndex(c => c.id == res.resultado);
        }

        if(res.girando == 1 && !running && resultadoFinal === null){
            // apenas usuários executam a animação temporária
            if (!<?= $isAdmin ? 'true' : 'false' ?>) {
                spinV2(null, false);
            }
        }

        if(resultadoFinal !== null && !running && !mostrouResultado){
            spinV2(resultadoFinal, false);
        }
    }, "json");
}, 2000);
</script>

<?php include("global/footer.php"); ?>
