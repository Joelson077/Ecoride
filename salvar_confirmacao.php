<?php
header("Content-Type: application/json");

// Conexão com o banco
$conn = new mysqli("localhost", "root", "", "ecoride");
if ($conn->connect_error) {
    echo json_encode(["status" => "erro", "mensagem" => "Erro na conexão."]);
    exit();
}

// Dados recebidos do JS
$input = json_decode(file_get_contents("php://input"), true);
$viagem_id = $input["viagem_id"];
$passageiro_id = $input["passageiro_id"];
$confirmacao = $input["confirmacao"];
$comentario = $input["comentario"] ?? null;

// 1. Salvar a confirmação
$stmt = $conn->prepare("INSERT INTO confirmacoes_viagem (viagem_id, passageiro_id, confirmacao, comentario) VALUES (?, ?, ?, ?)");
$stmt->bind_param("iiss", $viagem_id, $passageiro_id, $confirmacao, $comentario);
$salvou = $stmt->execute();

// 2. Se correu bem, dar créditos ao motorista
if ($salvou && $confirmacao === 'ok') {
    // Buscar o ID do motorista da viagem
    $sql = "SELECT motorista_id FROM viagens WHERE id = ?";
    $stmt2 = $conn->prepare($sql);
    $stmt2->bind_param("i", $viagem_id);
    $stmt2->execute();
    $resultado = $stmt2->get_result();

    if ($linha = $resultado->fetch_assoc()) {
        $motorista_id = $linha["motorista_id"];

        // Adicionar 10 créditos ao motorista (exemplo)
        $stmt3 = $conn->prepare("UPDATE usuarios SET creditos = creditos + 10 WHERE id = ?");
        $stmt3->bind_param("i", $motorista_id);
        $stmt3->execute();
    }
}

echo json_encode(["status" => $salvou ? "ok" : "erro"]);
