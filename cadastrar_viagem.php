<?php
header('Content-Type: application/json');

// Conexão com o banco de dados
$host = "localhost";
$user = "root";
$pass = ""; // Ajuste se tiver senha
$dbname = "ecoride";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    echo json_encode(["status" => "erro", "mensagem" => "Erro de conexão: " . $conn->connect_error]);
    exit();
}

// Receber dados do JSON
$data = json_decode(file_get_contents("php://input"), true);

// Verificar campos obrigatórios
$campos_obrigatorios = ['motorista_id', 'partida', 'chegada', 'preco', 'lugares_disponiveis', 'data_partida', 'veiculo_id'];
foreach ($campos_obrigatorios as $campo) {
    if (empty($data[$campo])) {
        echo json_encode(["status" => "erro", "mensagem" => "O campo '$campo' é obrigatório."]);
        exit();
    }
}

// Preparar SQL
$stmt = $conn->prepare("INSERT INTO viagens (motorista_id, partida, chegada, preco, lugares_disponiveis, data_partida, veiculo_id, criado_em) 
VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");

if (!$stmt) {
    echo json_encode(["status" => "erro", "mensagem" => "Erro ao preparar a query: " . $conn->error]);
    exit();
}

// Bind correto
$stmt->bind_param(
    "issiisi",
    $data['motorista_id'],
    $data['partida'],
    $data['chegada'],
    $data['preco'],
    $data['lugares_disponiveis'],
    $data['data_partida'],
    $data['veiculo_id']
);

// Executar
if ($stmt->execute()) {
    echo json_encode(["status" => "sucesso", "mensagem" => "Viagem cadastrada com sucesso."]);
} else {
    echo json_encode(["status" => "erro", "mensagem" => "Erro ao inserir viagem: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
