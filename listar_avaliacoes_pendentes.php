<?php
header("Content-Type: application/json");

$conn = new mysqli("localhost", "root", "", "ecoride");
if ($conn->connect_error) {
    echo json_encode([]);
    exit();
}

$sql = "SELECT id, nota, comentario FROM avaliacoes WHERE status = 'pendente'";
$result = $conn->query($sql);

$avaliacoes = [];

while ($row = $result->fetch_assoc()) {
    $avaliacoes[] = $row;
}

echo json_encode($avaliacoes);
