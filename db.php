<?php
$host = 'localhost';
$db = 'ecoride';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass);
} catch (PDOException $e) {
    echo 'Erro na conexão: ' . $e->getMessage();
    exit;
}
?>
