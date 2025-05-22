<?php
header("Content-Type: application/json");

// Conexão com o banco de dados
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "ecoride";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    echo json_encode(["status" => "erro", "mensagem" => "Erro na conexão: " . $conn->connect_error]);
    exit();
}

// Recebe o ID do motorista via JSON
$input = json_decode(file_get_contents("php://input"), true);
$motorista_id = isset($input['motorista_id']) ? (int)$input['motorista_id'] : 0;

if ($motorista_id <= 0) {
    echo json_encode(["status" => "erro", "mensagem" => "ID do motorista inválido."]);
    exit();
}

// Consulta viagens criadas pelo motorista
$sql = "SELECT id, partida, chegada, preco, lugares_disponiveis, data_partida, status FROM viagens WHERE motorista_id = ? ORDER BY data_partida DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $motorista_id);
$stmt->execute();
$result = $stmt->get_result();

$viagens = [];
while ($row = $result->fetch_assoc()) {
    $viagens[] = $row;
}

echo json_encode(["status" => "sucesso", "viagens" => $viagens]);

$stmt->close();
$conn->close();
?>
