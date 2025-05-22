<?php
header("Content-Type: application/json");
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "ecoride";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    echo json_encode(["status" => "erro", "mensagem" => "Erreur de connexion."]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);
$email = $data['email'] ?? '';
$senha = $data['senha'] ?? '';

if (empty($email) || empty($senha)) {
    echo json_encode(["status" => "erro", "mensagem" => "Champs obligatoires manquants."]);
    exit();
}

$stmt = $conn->prepare("SELECT id, pseudo, creditos FROM usuarios WHERE email = ? AND senha = ?");
$stmt->bind_param("ss", $email, $senha);
$stmt->execute();
$result = $stmt->get_result();

if ($usuario = $result->fetch_assoc()) {
    echo json_encode([
        "status" => "sucesso",
        "usuario" => [
            "id" => $usuario['id'],
            "nome" => $usuario['pseudo'],
            "creditos" => $usuario['creditos']
        ]
    ]);
} else {
    echo json_encode(["status" => "erro", "mensagem" => "Email ou mot de passe incorrect."]);
}

$stmt->close();
$conn->close();
?>
