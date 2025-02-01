<?php
session_start();
require_once '../config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT username FROM usuarios WHERE username = ?");
    $stmt->execute([$username]);
    
    if ($stmt->rowCount() > 0) {
        $error = "Erro ao cadastrar. Usuário já existe.";
    } else if (strlen($password) < 6) {
        $error = "A senha deve ter no mínimo 6 caracteres.";
    } else {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO usuarios (username, password) VALUES (?, ?)");
            $stmt->execute([$username, $hashedPassword]);
            $_SESSION['success'] = "Cadastro realizado com sucesso!";
            header("Location: index.php");
            exit;
        } catch(PDOException $e) {
            $error = "Erro ao cadastrar. Tente novamente.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cadastro</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-md w-96">
            <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Cadastro</h2>
            <?php if (isset($error)) echo "<p class='text-red-500 text-center mb-4'>$error</p>"; ?>
            <form method="post" class="space-y-4">
                <div>
                    <label class="block text-gray-700 mb-2">Usuário:</label>
                    <input type="text" name="username" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Senha:</label>
                    <input type="password" name="password" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <button type="submit" 
                        class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Cadastrar
                </button>
            </form>
            <p class="mt-4 text-center text-gray-600">
                Já tem conta? 
                <a href="index.php" class="text-blue-500 hover:text-blue-600">Faça login</a>
            </p>
        </div>
    </div>
</body>
</html>