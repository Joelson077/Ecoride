<?php
header('Content-Type: application/json');

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "ecoride";
$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    echo json_encode(["status" => "erro", "mensagem" => "Erro de conexão"]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);
$id = intval($data['viagem_id']);

$sql = "UPDATE viagens SET status = 'em_andamento' WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(["status" => "sucesso"]);
} else {
    echo json_encode(["status" => "erro", "mensagem" => "Erro ao iniciar a viagem"]);
}

$stmt->close();
$conn->close();
?>
