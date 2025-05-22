<?php
header("Content-Type: application/json");

// Conectar ao banco de dados
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "ecoride";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    echo json_encode(["status" => "erro", "mensagem" => "Erro na conexão: " . $conn->connect_error]);
    exit();
}

// Obter dados da requisição
$data = json_decode(file_get_contents("php://input"), true);
$usuario_id = isset($data['usuario_id']) ? (int)$data['usuario_id'] : 0;
$viagem_id = isset($data['viagem_id']) ? (int)$data['viagem_id'] : 0;

if ($usuario_id <= 0 || $viagem_id <= 0) {
    echo json_encode(["status" => "erro", "mensagem" => "Dados inválidos."]);
    exit();
}

// Remover participação
$stmt = $conn->prepare("DELETE FROM participacoes WHERE usuario_id = ? AND viagem_id = ?");
$stmt->bind_param("ii", $usuario_id, $viagem_id);

if ($stmt->execute()) {
    // Reembolsar créditos (20 por exemplo) e aumentar lugares
    $conn->query("UPDATE usuarios SET creditos = creditos + 20 WHERE id = $usuario_id");
    $conn->query("UPDATE viagens SET lugares_disponiveis = lugares_disponiveis + 1 WHERE id = $viagem_id");

    echo json_encode(["status" => "sucesso", "mensagem" => "Participação cancelada com sucesso."]);
} else {
    echo json_encode(["status" => "erro", "mensagem" => "Erro ao cancelar: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
