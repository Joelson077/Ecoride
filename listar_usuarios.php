<?php
header("Content-Type: application/json");
$conn = new mysqli("localhost", "root", "", "ecoride");

$result = $conn->query("SELECT id, pseudo AS nome, email, creditos FROM usuarios ORDER BY nome ASC");
$usuarios = [];

while ($row = $result->fetch_assoc()) {
    $usuarios[] = $row;
}

echo json_encode($usuarios);
