<?php
require "conexao.php";
header("Content-Type: application/json; charset=utf-8");

$conn->query("UPDATE status_roleta SET girando=0 WHERE id=1");
echo json_encode(["ok" => true]);
