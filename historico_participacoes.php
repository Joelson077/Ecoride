<?php
header("Content-Type: application/json");

// Conexão
$conn = new mysqli("localhost", "root", "", "ecoride");
if ($conn->connect_error) {
    echo json_encode(["status" => "erro", "mensagem" => "Erro de conexão: " . $conn->connect_error]);
    exit();
}

// Receber o ID do usuário via JSON
$data = json_decode(file_get_contents("php://input"), true);
$usuario_id = isset($data['usuario_id']) ? (int)$data['usuario_id'] : 0;

if ($usuario_id <= 0) {
    echo json_encode(["status" => "erro", "mensagem" => "ID de usuário inválido."]);
    exit();
}

// Consulta as viagens que o passageiro participou
$sql = "
    SELECT v.id, v.partida, v.chegada, v.data_partida
    FROM participacoes p
    JOIN viagens v ON p.viagem_id = v.id
    WHERE p.usuario_id = ?
    ORDER BY v.data_partida DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

$viagens = [];
while ($row = $result->fetch_assoc()) {
    $viagens[] = $row;
}

echo json_encode(["status" => "sucesso", "viagens" => $viagens]);

$stmt->close();
$conn->close();
