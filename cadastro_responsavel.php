<?php
include "conexao.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome     = trim($_POST["nome"]);
    $email    = trim($_POST["email"]);
    $senha    = password_hash($_POST["senha"], PASSWORD_DEFAULT);
    $telefone = trim($_POST["telefone"]);

    $sql = "INSERT INTO responsaveis (nome, email, senha, telefone) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssss", $nome, $email, $senha, $telefone);
        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            header("Location: index.php");
            exit();
        } else {
            echo "Erro ao executar a inserção: " . $stmt->error;
        }
    } else {
        echo "Erro ao preparar a consulta: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Responsável - Conta Veio</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        :root {
            --background-color: #f0f4f8;
            --text-color: #333333;
            --box-background-color: #ffffff;
            --input-background-color: #e0e0e0;
            --button-background-color: #007bff;
            --button-hover-color: #0056b3;
            --link-color: #007bff;
        }

        [data-theme="dark"] {
            --background-color: #121212;
            --text-color: #ffffff;
            --box-background-color: #1e1e1e;
            --input-background-color: #333333;
            --button-background-color: #4444ff;
            --button-hover-color: #3333cc;
            --link-color: #4a90e2;
        }

        body {
            background-color: var(--background-color);
            color: var(--text-color);
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .theme-toggle {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: var(--button-background-color);
            color: #ffffff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .theme-toggle:hover {
            background-color: var(--button-hover-color);
        }

        .form-box {
            background-color: var(--box-background-color);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 20px;
            max-width: 450px;
            margin: 100px auto;
            text-align: center;
        }

        .form-box h1 {
            margin-bottom: 10px;
        }

        .form-box h2 {
            margin-bottom: 20px;
        }

        .form-box form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .form-box .input-group {
            display: flex;
            align-items: center;
            width: 100%;
            margin-bottom: 15px;
        }

        .form-box .input-group i {
            margin-right: 12px;
            color: var(--link-color);
        }

        .form-box .input-group input {
            flex: 1;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: var(--input-background-color);
            color: var(--text-color);
        }

        .form-box button {
            background-color: var(--button-background-color);
            color: #ffffff;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: auto;
        }

        .form-box button i {
            color: #fff !important;
            margin-right: 8px;
        }

        .form-box button:hover {
            background-color: var(--button-hover-color);
        }

        .form-box a {
            color: var(--link-color);
            text-decoration: none;
            display: block;
            margin-top: 10px;
        }

        .form-box a:hover {
            text-decoration: underline;
        }

        .form-box a i {
            color: var(--link-color);
            margin-right: 6px;
        }

        .theme-toggle i {
            color: var(--link-color);
            margin-right: 6px;
        }
    </style>
</head>
<body>
    <button class="theme-toggle" onclick="toggleTheme()">
        <i class="fas fa-adjust"></i> Alternar Tema
    </button>

    <div class="form-box">
        <h1>Conta Veio</h1>
        <h2>Cadastrar Responsável</h2>
        <form method="POST" action="">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="nome" placeholder="Nome completo" required>
            </div>
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="senha" placeholder="Senha" required>
            </div>
            <div class="input-group">
                <i class="fas fa-phone"></i>
                <input type="text" name="telefone" placeholder="Telefone" required>
            </div>
            <button type="submit"><i class="fas fa-user-plus"></i> Cadastrar</button>
            <a href="index.php"><i class="fas fa-arrow-left"></i> Voltar</a>
        </form>
    </div>

    <script>
        function toggleTheme() {
            const body = document.body;
            const currentTheme = body.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            body.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
        }

        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            document.body.setAttribute('data-theme', savedTheme);
        }
    </script>
</body>
</html>
