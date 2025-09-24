<?php
$host = "localhost";
$port = 3307;
$user = "root"; // usuário padrão do XAMPP
$pass = "";     // senha padrão é vazia
$db   = "votacao";

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}
?>