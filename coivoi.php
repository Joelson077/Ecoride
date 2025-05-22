<?php
// Conexão com o banco de dados
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "ecoride";

$conn = new mysqli($host, $user, $pass, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}


?>