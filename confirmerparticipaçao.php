<?php

// Conectar ao banco de dados
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'ecoride';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die('Erro na conexão: ' . $conn->connect_error);
}

// Obter os dados do formulário
$id_usuario = $_POST['id_usuario'];
$id_viagem = $_POST['id_viagem'];
$preco = $_POST['preco'];

// Verificar os créditos do usuário
$sql = 'SELECT creditos FROM usuarios WHERE id = ?';
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id_usuario);
$stmt->execute();
$stmt->bind_result($creditos);
$stmt->fetch();
$stmt->close();

if ($creditos < $preco) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Créditos insuficientes.']);
    exit();
}

// Verificar lugares disponíveis
$sql = 'SELECT lugares_disponiveis FROM covoiturages WHERE id = ?';
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id_viagem);
$stmt->execute();
$stmt->bind_result($lugares);
$stmt->fetch();
$stmt->close();

if ($lugares <= 0) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Não há lugares disponíveis.']);
    exit();
}

// Atualizar créditos e lugares
$new_creditos = $creditos - $preco;
$new_lugares = $lugares - 1;

$sql = 'UPDATE usuarios SET creditos = ? WHERE id = ?';
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $new_creditos, $id_usuario);
$stmt->execute();
$stmt->close();

$sql = 'UPDATE covoiturages SET lugares_disponiveis = ? WHERE id = ?';
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $new_lugares, $id_viagem);
$stmt->execute();
$stmt->close();

echo json_encode(['status' => 'sucesso', 'mensagem' => 'Participação confirmada!']);

$conn->close();

?>
