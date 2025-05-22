<?php
header("Content-Type: application/json");
$conn = new mysqli("localhost", "root", "", "ecoride");

$input = json_decode(file_get_contents("php://input"), true);
$email = trim($input["email"]);
$senha = trim($input["senha"]);

$stmt = $conn->prepare("SELECT id, nome FROM admins WHERE email = ? AND senha = ?");
$stmt->bind_param("ss", $email, $senha);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode(["status" => "ok", "nome" => $row["nome"]]);
} else {
    echo json_encode(["status" => "erro"]);
}
