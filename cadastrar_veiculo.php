<?php
header("Content-Type: application/json");

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "ecoride";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    echo json_encode(["status" => "erro", "mensagem" => "Erro na conexão com o banco: " . $conn->connect_error]);
    exit();
}

// Validação básica
if (
    !isset($_POST['motorista_id'], $_POST['marca'], $_POST['modelo'], $_POST['cor'],
             $_POST['placa'], $_POST['data_primeira_immatriculation'],
             $_POST['preferencias'], $_POST['tipo_energia'], $_FILES['foto'])
) {
    echo json_encode(["status" => "erro", "mensagem" => "Dados incompletos."]);
    exit();
}

$motorista_id = intval($_POST["motorista_id"]);
$marca = $_POST["marca"];
$modelo = $_POST["modelo"];
$cor = $_POST["cor"];
$placa = $_POST["placa"];
$data_immatriculation = $_POST["data_primeira_immatriculation"];
$preferencias = $_POST["preferencias"];
$tipo_energia = $_POST["tipo_energia"];

// Upload da foto com nome único e seguro
$fotoNome = $_FILES['foto']['name'];
$fotoTmp = $_FILES['foto']['tmp_name'];
$ext = pathinfo($fotoNome, PATHINFO_EXTENSION);
$fotoFinal = "foto_" . uniqid() . "." . strtolower($ext);
$fotoPath = "uploads/" . $fotoFinal;

if (!move_uploaded_file($fotoTmp, $fotoPath)) {
    echo json_encode(["status" => "erro", "mensagem" => "Erro ao mover a foto para a pasta de uploads."]);
    exit();
}

// Atualiza a foto no usuário
$updateFoto = $conn->prepare("UPDATE usuarios SET foto = ? WHERE id = ?");
$updateFoto->bind_param("si", $fotoPath, $motorista_id);
$updateFoto->execute();
$updateFoto->close();

// Inserir o veículo
$insertVeiculo = $conn->prepare("INSERT INTO veiculos (motorista_id, marca, modelo, cor, placa, data_primeira_immatriculation, preferencias, tipo_energia) 
                                 VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$insertVeiculo->bind_param("isssssss", $motorista_id, $marca, $modelo, $cor, $placa, $data_immatriculation, $preferencias, $tipo_energia);

if ($insertVeiculo->execute()) {
    echo json_encode(["status" => "sucesso"]);
} else {
    echo json_encode(["status" => "erro", "mensagem" => $insertVeiculo->error]);
}

$insertVeiculo->close();
$conn->close();
?>
