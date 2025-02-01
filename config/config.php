<?php
$host = 'db';
$dbname = 'devops_db';
$username = 'devops';
$password = 'devops_password';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Conexão falhou: " . $e->getMessage();
}
?>