<?php
header('Content-Type: application/json');

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "ecoride";
$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    echo json_encode(["status" => "erro", "mensagem" => "Erreur de connexion à la base de données"]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);
$viagem_id = intval($data['viagem_id']);

if ($viagem_id <= 0) {
    echo json_encode(["status" => "erro", "mensagem" => "ID de trajet invalide"]);
    exit();
}

// 1. Atualiza o status da viagem
$sql = "UPDATE viagens SET status = 'finalizada' WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $viagem_id);
$sucesso = $stmt->execute();
$stmt->close();

if (!$sucesso) {
    echo json_encode(["status" => "erro", "mensagem" => "Erreur lors de la finalisation du trajet"]);
    exit();
}

// 2. Buscar os passageiros
$sql_passageiros = "
    SELECT u.email, u.id AS passageiro_id
    FROM participacoes p
    JOIN usuarios u ON p.usuario_id = u.id
    WHERE p.viagem_id = ?
";

$stmt2 = $conn->prepare($sql_passageiros);
$stmt2->bind_param("i", $viagem_id);
$stmt2->execute();
$result = $stmt2->get_result();

$mensagens = [];

while ($row = $result->fetch_assoc()) {
    $email = $row['email'];
    $passageiro_id = $row['passageiro_id'];

    $link = "http://localhost/ecoride/avaliar_viagem.html?viagem_id=$viagem_id&passageiro_id=$passageiro_id";

    $mensagem = "À : $email\n";
    $mensagem .= "Objet : Confirmation de votre covoiturage EcoRide\n";
    $mensagem .= "Message :\n";
    $mensagem .= "Bonjour, votre trajet vient d’être terminé.\n";
    $mensagem .= "Merci de confirmer si tout s’est bien passé en accédant au lien suivant :\n";
    $mensagem .= "$link\n\n";

    $mensagens[] = $mensagem;
}

$stmt2->close();
$conn->close();

// 3. Salva simulação dos e-mails
file_put_contents("simulacao_emails.log", implode("\n----------------------\n", $mensagens), FILE_APPEND);

// 4. Retorno final
echo json_encode([
    "status" => "sucesso",
    "mensagem" => "Trajet finalisé. E-mails simulés enregistrés."
]);
