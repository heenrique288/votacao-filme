<?php
include "conexao.php";

if (isset($_GET['reset'])) {
    $conn->query("UPDATE status_votacao SET roleta_ativa = 0");
    echo json_encode(["ok" => true]);
    exit;
}

$res = $conn->query("SELECT roleta_ativa, ids FROM status_votacao ORDER BY atualizado_em DESC LIMIT 1");

if ($res && $row = $res->fetch_assoc()) {
    echo json_encode($row);
} else {
    echo json_encode(["roleta_ativa" => 0]);
}
