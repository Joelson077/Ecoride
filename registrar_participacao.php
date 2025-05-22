<?php
header("Content-Type: application/json");

// Log da requisição bruta (para verificar se está chegando corretamente)
$raw = file_get_contents("php://input");
file_put_contents("debug_participacao.log", date('Y-m-d H:i:s') . " - " . $raw . PHP_EOL, FILE_APPEND);

// Conexão
$conn = new mysqli("localhost", "root", "", "ecoride");

if ($conn->connect_error) {
    echo json_encode(["status" => "erro", "mensagem" => "Erro na conexão com o banco."]);
    exit();
}

// Decodifica os dados JSON recebidos
$data = json_decode($raw, true);
$usuario_id = isset($data['usuario_id']) ? (int)$data['usuario_id'] : 0;
$viagem_id = isset($data['viagem_id']) ? (int)$data['viagem_id'] : 0;
$creditos = isset($data['creditos']) ? (int)$data['creditos'] : 0;

// Validação dos dados
if ($usuario_id <= 0 || $viagem_id <= 0 || $creditos <= 0) {
    echo json_encode(["status" => "erro", "mensagem" => "Dados inválidos recebidos."]);
    exit();
}

// Verifica se já existe participação
$check = $conn->prepare("SELECT 1 FROM participacoes WHERE usuario_id = ? AND viagem_id = ?");
$check->bind_param("ii", $usuario_id, $viagem_id);
$check->execute();
$check->store_result();
if ($check->num_rows > 0) {
    echo json_encode(["status" => "erro", "mensagem" => "Você já está inscrito nesta viagem."]);
    $check->close();
    $conn->close();
    exit();
}
$check->close();

// Insere participação
$stmt = $conn->prepare("INSERT INTO participacoes (usuario_id, viagem_id) VALUES (?, ?)");
$stmt->bind_param("ii", $usuario_id, $viagem_id);

if ($stmt->execute()) {
    // Atualiza créditos do usuário
    $conn->query("UPDATE usuarios SET creditos = creditos - $creditos WHERE id = $usuario_id");

    // Atualiza lugares disponíveis
    $conn->query("UPDATE viagens SET lugares_disponiveis = lugares_disponiveis - 1 WHERE id = $viagem_id");

    echo json_encode(["status" => "sucesso", "mensagem" => "Participação salva com sucesso."]);
} else {
    echo json_encode(["status" => "erro", "mensagem" => "Erro ao salvar participação: " . $stmt->error]);
}

$stmt->close();
$conn->close();
