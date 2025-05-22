<?php
header("Content-Type: application/json");
$conn = new mysqli("localhost", "root", "", "ecoride");

// Total de créditos ganhos
$total_creditos_result = $conn->query("SELECT SUM(creditos) AS total FROM usuarios");
$total_creditos = $total_creditos_result->fetch_assoc()["total"] ?? 0;

// Total de viagens
$total_viagens_result = $conn->query("SELECT COUNT(*) AS total FROM viagens");
$total_viagens = $total_viagens_result->fetch_assoc()["total"] ?? 0;

// Viagens por dia
$viagens_dia_result = $conn->query("
    SELECT DATE_FORMAT(criado_em, '%Y-%m-%d') AS dia, COUNT(*) AS total
    FROM viagens
    GROUP BY dia
    ORDER BY dia DESC
    LIMIT 7
");
$viagens_por_dia = [];
while ($row = $viagens_dia_result->fetch_assoc()) {
    $viagens_por_dia[] = $row;
}
$viagens_por_dia = array_reverse($viagens_por_dia); // mais antigas primeiro

// Créditos por dia
$creditos_dia_result = $conn->query("
    SELECT DATE_FORMAT(criado_em, '%Y-%m-%d') AS dia, SUM(creditos) AS total
    FROM usuarios
    GROUP BY dia
    ORDER BY dia DESC
    LIMIT 7
");
$creditos_por_dia = [];
while ($row = $creditos_dia_result->fetch_assoc()) {
    $creditos_por_dia[] = $row;
}
$creditos_por_dia = array_reverse($creditos_por_dia);

echo json_encode([
    "total_creditos" => (int)$total_creditos,
    "total_viagens" => (int)$total_viagens,
    "viagens_por_dia" => $viagens_por_dia,
    "creditos_por_dia" => $creditos_por_dia
]);
