<?php
header("Content-Type: application/json");
$conn = new mysqli("localhost", "root", "", "ecoride");

$input = json_decode(file_get_contents("php://input"), true);
$nome = trim($input["nome"]);
$email = trim($input["email"]);
$senha = trim($input["senha"]);

$stmt = $conn->prepare("SELECT id FROM admins WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo json_encode(["status" => "erro", "mensagem" => "E-mail já cadastrado"]);
    exit();
}

$stmt = $conn->prepare("INSERT INTO admins (nome, email, senha) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $nome, $email, $senha);

if ($stmt->execute()) {
    echo json_encode(["status" => "ok"]);
} else {
    echo json_encode(["status" => "erro", "mensagem" => "Erro ao cadastrar"]);
}
