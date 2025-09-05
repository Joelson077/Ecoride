<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'ecoride'; // troque pelo nome do seu banco, se necessário

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("❌ Erro de conexão: " . $conn->connect_error);
}
echo "✅ Conectado com sucesso ao banco local!";
?>
