<?php
header("Content-Type: application/json");

// Exibe erros no ambiente de teste
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Conexão com o banco
$conn = new mysqli("localhost", "root", "", "ecoride");
if ($conn->connect_error) {
    echo json_encode(["status" => "erro", "mensagem" => "Erro na conexão"]);
    exit();
}

// Recebe os dados do JSON
$input = json_decode(file_get_contents("php://input"), true);
$email = trim($input["email"]);
$senha = trim($input["senha"]);

// Consulta o funcionário
$stmt = $conn->prepare("SELECT id, nome, senha FROM funcionarios WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    // Comparação direta da senha (se quiser, pode usar password_hash futuramente)
    if ($senha === $row["senha"]) {
        // Login válido
        echo json_encode(["status" => "ok", "id" => $row["id"], "nome" => $row["nome"]]);
        exit();
    }
}

// Se chegou aqui, login inválido
echo json_encode(["status" => "erro"]);
