<?php
$host = 'localhost';
$db = 'teste';
$user = 'postgres'; // Usuário PostgreSQL
$pass = '123';        // Senha do usuário PostgreSQL

$dsn = "pgsql:host=$host;dbname=$db";
try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Conexão falhou: ' . $e->getMessage();
}
?>