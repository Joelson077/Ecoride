<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "", "ecoride");

$data = json_decode(file_get_contents("php://input"), true);
$id = isset($data["id"]) ? (int)$data["id"] : 0;

if ($id > 0) {
  $sql = "UPDATE usuarios SET ativo = 0 WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $id);
  if ($stmt->execute()) {
    echo json_encode(["status" => "ok", "mensagem" => "Usuário suspenso com sucesso"]);
  } else {
    echo json_encode(["status" => "erro", "mensagem" => "Erro ao suspender"]);
  }
} else {
  echo json_encode(["status" => "erro", "mensagem" => "ID inválido"]);
}
?>
