<?php
$host = 'localhost';
$user = 'root';
$pass = ''; // sem senha
$db   = 'ecoride'; // substitua se seu banco tiver outro nome

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}
?>
