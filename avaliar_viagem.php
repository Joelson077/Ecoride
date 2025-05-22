<?php
header("Content-Type: application/json");

// Conexão com o banco de dados
$conn = new mysqli("localhost", "root", "", "ecoride");

if ($conn->connect_error) {
    echo json_encode(["status" => "erro", "mensagem" => "Erro de conexão"]);
    exit();
}

// Captura os dados recebidos em JSON
$input = json_decode(file_get_contents("php://input"), true);

$viagem_id = (int)$input["viagem_id"];
$passageiro_id = (int)$input["passageiro_id"];
$nota = (int)$input["nota"];
$comentario = trim($input["comentario"]);

// Validações simples
if ($nota < 1 || $nota > 5) {
    echo json_encode(["status" => "erro", "mensagem" => "Nota inválida"]);
    exit();
}

// Insere a avaliação no banco
$stmt = $conn->prepare("INSERT INTO avaliacoes (viagem_id, passageiro_id, nota, comentario, status) VALUES (?, ?, ?, ?, 'pendente')");
$stmt->bind_param("iiis", $viagem_id, $passageiro_id, $nota, $comentario);

if ($stmt->execute()) {
    echo json_encode(["status" => "ok"]);
} else {
    echo json_encode(["status" => "erro", "mensagem" => "Erro ao salvar avaliação"]);
}
