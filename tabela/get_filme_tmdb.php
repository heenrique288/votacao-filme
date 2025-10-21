<?php 

include("../conexao.php"); 

$apiKey = "76aa3e8d299c64cc616c04567e05a080"; 
$usuarioId = intval($_GET['id']); 

$sql = "SELECT titulo, ano FROM filmes WHERE usuario_id = $usuarioId"; 
$result = $conn->query($sql); 

$urls = []; 
$filmes = []; 

// Monta todas as URLs antes 
while($row = $result->fetch_assoc()) { 
    $nomeFilme = urlencode($row['titulo']); 
    $ano = intval($row['ano']); 
    
    if ($ano > 0) { 
        $urls[] = "https://api.themoviedb.org/3/search/movie?api_key=$apiKey&query=$nomeFilme&language=pt-BR&primary_release_year=$ano"; 
    } else { 
        $urls[] = "https://api.themoviedb.org/3/search/movie?api_key=$apiKey&query=$nomeFilme&language=pt-BR"; 
    } 
} 
// Inicializa multi-cURL 
$multiCurl = []; 
$mh = curl_multi_init(); 

foreach($urls as $i => $url){ 
    $multiCurl[$i] = curl_init(); 
    curl_setopt($multiCurl[$i], CURLOPT_URL, $url); 
    curl_setopt($multiCurl[$i], CURLOPT_RETURNTRANSFER, true); 
    curl_multi_add_handle($mh, $multiCurl[$i]); 
} 
// Executa todas as requisições ao mesmo tempo 
$running = null; 
do { 
    curl_multi_exec($mh, $running); 
    curl_multi_select($mh); 
} while ($running > 0); 

// Coleta os resultados 
foreach($multiCurl as $ch){ 
    $response = curl_multi_getcontent($ch); 
    $data = json_decode($response, true); 

    if (isset($data['results'][0])) { 
        $filmeTMDB = $data['results'][0]; 
        $filmes[] = [ 
            'titulo' => $filmeTMDB['title'], 
            'sinopse' => $filmeTMDB['overview'], 
            'banner' => "https://image.tmdb.org/t/p/w500" . $filmeTMDB['poster_path'] 
        ]; 
    } 
    
    curl_multi_remove_handle($mh, $ch); 
    curl_close($ch); 
} 

curl_multi_close($mh); 

header('Content-Type: application/json'); 
echo json_encode($filmes);
?>