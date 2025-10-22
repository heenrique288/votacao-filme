<?php 
include("../conexao.php");



$sqlUsuarios = "SELECT * FROM usuarios ORDER BY votos DESC";
$resultUsuarios = $conn->query($sqlUsuarios);

$posicao = 1;
$votosAnterior = null;

$nomes = [
    1 => "do Edu",
    2 => "do Théo",
    3 => "do Henrique",
    4 => "do João",
    5 => "do Alan",
    6 => "do Carlos",
    7 => "do Guilherme",
    8 => "do Gabriel",
    9 => "da Dutra",
];

?>
<?php include("../global/header.php"); ?>
<head>
    <link rel="stylesheet" href="../src/css/tabela.css">
    <script src="../src/js/tabela.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<main>
    <div class="centralizar">
        <section class="search-section py-5 bg-tabela">
            <div class="container text-center">
                <h1 class="titulo-principal mb-4">
                    <span class="coroa1">&#9813;</span>
                    Maiores vencedores da Votação!
                    <span class="coroa2">&#9813;</span>
                </h1>
            </div>
        </section>
    
        <table>
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Posição</th>
                    <th>Nome</th>
                    <th>Votos</th>
                    <th>Filmes</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($usuario = $resultUsuarios->fetch_assoc()): ?>
    
                    <?php
                        if ($votosAnterior === null) {
                            $usuario['posicao_dinamica'] = $posicao;
                        } elseif ($usuario['votos'] == $votosAnterior) {
                            $usuario['posicao_dinamica'] = $posicao;
                        } else {
                            $posicao++;
                            $usuario['posicao_dinamica'] = $posicao;
                        }
    
                        $votosAnterior = $usuario['votos'];
                        $nome = isset($nomes[$usuario['id']]) ? $nomes[$usuario['id']] : "";
                    ?>
    
                    <tr>
                        <td>
                            <div class="foto">
                                <img src="<?= $usuario['foto'] ?>" alt="<?= $usuario['nome'] ?>">
                            </div>
                        </td>
                        <td>
                            <?php
                                if ($usuario['posicao_dinamica'] == 1) {
                                    echo '<i class="fa-solid fa-medal medalha" style="color: rgb(255, 232, 103);"></i>';
                                } elseif ($usuario['posicao_dinamica'] == 2) {
                                    echo '<i class="fa-solid fa-medal medalha" style="color: silver;"></i>';
                                } elseif ($usuario['posicao_dinamica'] == 3) {
                                    echo '<i class="fa-solid fa-medal medalha" style="color: #cd7f32;"></i>';
                                } else {
                                    echo $usuario['posicao_dinamica'] . '°';
                                }
                            ?>
                        </td>
                        <td><?= $usuario['nome'] ?></td>
                        <td><?= $usuario['votos'] ?></td>
                        <td>
                            <a href="#" onclick="abrirPopup(<?= $usuario['id'] ?>)">
                                Ver filmes <?= $nome ?>
                            </a>
                        </td>
                    </tr>
    
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</main>

<?php include("../global/footer.php"); ?>