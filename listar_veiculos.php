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

// Receber o JSON
$input = json_decode(file_get_contents("php://input"), true);

// Verificar se motorista_id veio corretamente
if (!isset($input['motorista_id']) || !is_numeric($input['motorista_id']) || $input['motorista_id'] <= 0) {
    echo json_encode(["status" => "erro", "mensagem" => "ID do motorista inválido."]);
    exit();
}

$motorista_id = (int)$input['motorista_id'];

// Buscar veículos do motorista
$sql = "SELECT id, marca, modelo, cor, placa FROM veiculos WHERE motorista_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode(["status" => "erro", "mensagem" => "Erro na preparação da consulta: " . $conn->error]);
    exit();
}

$stmt->bind_param("i", $motorista_id);
$stmt->execute();
$result = $stmt->get_result();

$veiculos = [];
while ($row = $result->fetch_assoc()) {
    $veiculos[] = $row;
}

echo json_encode(["status" => "sucesso", "veiculos" => $veiculos]);

$stmt->close();
$conn->close();
?>
