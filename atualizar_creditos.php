<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "ecoride";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    echo json_encode(["status" => "erro", "mensagem" => "Erro na conexão com o banco de dados."]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['usuario_id']) || !isset($data['creditos'])) {
    echo json_encode(["status" => "erro", "mensagem" => "Dados incompletos."]);
    exit();
}

$usuario_id = intval($data['usuario_id']);
$novos_creditos = intval($data['creditos']);

$sql = "UPDATE usuarios SET creditos = ? WHERE id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode(["status" => "erro", "mensagem" => "Erro ao preparar a consulta."]);
    exit();
}

$stmt->bind_param("ii", $novos_creditos, $usuario_id);

if ($stmt->execute()) {
    echo json_encode(["status" => "sucesso", "mensagem" => "Créditos atualizados."]);
} else {
    echo json_encode(["status" => "erro", "mensagem" => "Erro ao atualizar créditos."]);
}

$stmt->close();
$conn->close();
?>
