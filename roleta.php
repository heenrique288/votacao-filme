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

// checar admin
$stmt = $conn->prepare("SELECT admin FROM login WHERE id = ?");
$stmt->bind_param("i", $usuarioId);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
if (intval($row['admin']) !== 1) {
    $_SESSION['mensagem'] = "Acesso negado: apenas admin.";
    $_SESSION['tipo'] = "error";
    header("Location: home.php");
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
        <button id="spinBtn" class="btn btn-primary btn-lg">Girar roleta</button>
    </div>

    <div class="text-center">
        <a href="home.php" class="btn btn-secondary">Cancelar</a>
    </div>
</div>

<script>
const candidates = <?= json_encode($candidates, JSON_HEX_TAG) ?>;

// elementos
const nomeFilme = document.getElementById('nomeFilme');
const cartaz = document.getElementById('cartaz');
const spinBtn = document.getElementById('spinBtn');

let running = false;

// função pra mostrar candidato
function showCandidate(idx) {
    const c = candidates[idx];
    nomeFilme.textContent = c.titulo;
    if (c.poster_path) {
        cartaz.innerHTML = `<img src="https://image.tmdb.org/t/p/w342${c.poster_path}" alt="${c.titulo}" class="img-fluid rounded shadow">`;
    } else {
        cartaz.innerHTML = `<div class="bg-secondary text-white p-5">Sem imagem</div>`;
    }
}

// animação simples: muda candidato rapidamente e desacelera
function spin() {
    if (running) return;
    running = true;
    spinBtn.disabled = true;

    const totalCycles = 40 + Math.floor(Math.random()*30); // variação
    let i = 0;
    let idx = 0;
    let interval = 60;

    const timer = setInterval(() => {
        showCandidate(idx % candidates.length);
        idx++;
        i++;
        // desacelera progressivamente
        if (i > totalCycles * 0.6) interval += 6;
        if (i > totalCycles * 0.8) interval += 10;
        if (i >= totalCycles) {
            clearInterval(timer);
            running = false;
            spinBtn.disabled = false;
            // escolha final
            const chosenIndex = (idx - 1) % candidates.length;
            const chosen = candidates[chosenIndex];
            // pedir confirmação antes de enviar
            if (confirm('Confirmar vencedor: ' + chosen.titulo + ' ?')) {
                // enviar POST para finalizar_votacao.php
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
        }
    }, interval);

    // para incrementar o intervalo dinâmicamente (não suportado diretamente no setInterval),
    // em navegadores restantes o code acima ajusta 'interval' mas setInterval mantém o antigo.
    // Implementação simples para efeito: usar setTimeout recursivo em vez de setInterval:
}

// alternativa com setTimeout recursivo para desaceleração correta
function spinV2() {
    if (running) return;
    running = true;
    spinBtn.disabled = true;

    const totalSteps = 60 + Math.floor(Math.random()*40);
    let step = 0;
    let idx = 0;

    function stepFn() {
        showCandidate(idx % candidates.length);
        idx++;
        step++;
        // tempo cresce com o passo -> desacelera
        let delay = 30 + Math.floor( Math.pow(step / totalSteps, 2) * 400 );
        if (step < totalSteps) {
            setTimeout(stepFn, delay);
        } else {
            running = false;
            spinBtn.disabled = false;
            const chosenIndex = (idx - 1) % candidates.length;
            const chosen = candidates[chosenIndex];
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
            }, 800);
        }
    }

    stepFn();
}

spinBtn.addEventListener('click', () => {
    // usar spinV2 para animação mais suave
    spinV2();
});

// mostra primeiro candidato
showCandidate(0);
</script>

<?php include("global/footer.php"); ?>
