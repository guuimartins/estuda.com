<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Bem-vindo</title>
    <style>
        body { font-family: Arial; margin: 50px; }
    </style>
</head>
<body>
    <h2>Bem-vindo, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
    <p>Você está logado como devops.</p>
    <a href="logout.php">Sair</a>
</body>
</html>