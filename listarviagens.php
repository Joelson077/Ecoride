<?php
header("Content-Type: application/json");

$conn = new mysqli("localhost", "root", "", "ecoride");
if ($conn->connect_error) {
  echo json_encode(["status" => "erro", "mensagem" => "Erro na conexão com o banco."]);
  exit();
}

$sql = "SELECT v.id, v.partida, v.chegada, v.preco, v.lugares_disponiveis, v.data_partida,
               u.pseudo AS motorista, u.foto, ve.tipo_energia
        FROM viagens v
        JOIN usuarios u ON v.motorista_id = u.id
        JOIN veiculos ve ON v.veiculo_id = ve.id
        ORDER BY v.data_partida DESC";

$res = $conn->query($sql);
$viagens = [];

while ($row = $res->fetch_assoc()) {
  $viagens[] = [
    "id" => $row["id"],
    "partida" => $row["partida"],
    "chegada" => $row["chegada"],
    "preco" => (float)$row["preco"],
    "lugares_disponiveis" => (int)$row["lugares_disponiveis"],
    "motorista" => $row["motorista"],
    "eco" => strtolower($row["tipo_energia"]) === "électrique",
    "foto" => $row["foto"] ?? "default.jpg"
  ];
}

echo json_encode($viagens);
?>
