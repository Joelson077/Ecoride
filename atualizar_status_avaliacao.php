<?php
header("Content-Type: application/json");

$conn = new mysqli("localhost", "root", "", "ecoride");
if ($conn->connect_error) {
    echo json_encode(["status" => "erro"]);
    exit();
}

$input = json_decode(file_get_contents("php://input"), true);
$id = (int)$input["id"];
$status = in_array($input["status"], ["aprovada", "rejeitada"]) ? $input["status"] : null;

if ($status) {
    $stmt = $conn->prepare("UPDATE avaliacoes SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();

    echo json_encode(["status" => "ok"]);
} else {
    echo json_encode(["status" => "erro"]);
}
