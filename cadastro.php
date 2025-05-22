<?php
// Conexão com o banco de dados
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "ecoride";

$conn = new mysqli($host, $user, $pass, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    echo json_encode(["status" => "erro", "mensagem" => "Erro na conexão com o banco de dados: " . $conn->connect_error]);
    exit();
}

// Coletar dados do formulário
$nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
$sobrenome = isset($_POST['sobrenome']) ? trim($_POST['sobrenome']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$senha = isset($_POST['senha']) ? $_POST['senha'] : '';
$pseudo = $nome . " " . $sobrenome;

// Verificações básicas
if (empty($nome) || empty($sobrenome) || empty($email) || empty($senha)) {
    echo json_encode(["status" => "erro", "mensagem" => "Todos os campos são obrigatórios."]);
    exit();
}

// Validação da senha
if (!preg_match('/^(?=.*[a-zA-Z])(?=.*\d).{8,}$/', $senha)) {
    echo json_encode(["status" => "erro", "mensagem" => "A senha deve ter pelo menos 8 caracteres, incluindo letras e números."]);
    exit();
}

// Criptografar a senha
$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

// Verificar se o e-mail já está cadastrado
$sql_check = "SELECT id FROM usuarios WHERE email = ?";
$stmt_check = $conn->prepare($sql_check);

if (!$stmt_check) {
    echo json_encode(["status" => "erro", "mensagem" => "Erro ao preparar a consulta: " . $conn->error]);
    exit();
}

$stmt_check->bind_param("s", $email);
$stmt_check->execute();
$stmt_check->store_result();

if ($stmt_check->num_rows > 0) {
    echo json_encode(["status" => "erro", "mensagem" => "Este e-mail já está cadastrado."]);
    exit();
}

// Créditos iniciais
$creditos = 20;

// Inserir novo usuário
$sql = "INSERT INTO usuarios (pseudo, email, senha, creditos) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode(["status" => "erro", "mensagem" => "Erro ao preparar a inserção: " . $conn->error]);
    exit();
}

$stmt->bind_param("sssi", $pseudo, $email, $senha_hash, $creditos);

if ($stmt->execute()) {
    $user_id = $stmt->insert_id;
    echo json_encode(["status" => "sucesso", "id" => $user_id, "nome" => $nome, "sobrenome" => $sobrenome, "email" => $email, "creditos" => $creditos]);
} else {
    echo json_encode(["status" => "erro", "mensagem" => "Erro ao executar a inserção: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
