<?php
header("Content-Type: application/json");

$conn = new mysqli("localhost", "root", "", "ecoride");
if ($conn->connect_error) {
    echo json_encode(["status" => "erro", "mensagem" => "Erro na conexão"]);
    exit();
}

$input = json_decode(file_get_contents("php://input"), true);

$nome = trim($input["nome"]);
$email = trim($input["email"]);
$senha = trim($input["senha"]);

// Verifica se o e-mail já existe
$stmt = $conn->prepare("SELECT id FROM funcionarios WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo json_encode(["status" => "erro", "mensagem" => "E-mail já cadastrado"]);
    exit();
}

// Insere novo funcionário
$stmt = $conn->prepare("INSERT INTO funcionarios (nome, email, senha) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $nome, $email, $senha);

if ($stmt->execute()) {
    echo json_encode(["status" => "ok"]);
} else {
    echo json_encode(["status" => "erro"]);
}
