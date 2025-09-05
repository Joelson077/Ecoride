<?php
require_once 'db.php';


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
