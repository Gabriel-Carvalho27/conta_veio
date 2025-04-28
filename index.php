<?php
session_start();
include "conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $senha = $_POST["senha"];


    $stmt = $conn->prepare("SELECT * FROM responsaveis WHERE email = ? AND senha = ?");
    $stmt->bind_param("ss", $email, $senha);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $_SESSION["logado"] = true;
        header("Location: chamada.php");
        exit;
    } else {
        echo "<script>alert('Login inválido');</script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Conta Veio</title>
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
            --link-color: #4444ff;
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

        .login-box {
            background-color: var(--box-background-color);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 20px;
            max-width: 450px;
            margin: 100px auto;
            text-align: center;
        }

        .login-box h2 {
            margin-bottom: 20px;
        }

        .login-box form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .login-box .input-group {
            display: flex;
            align-items: center;
            width: 100%;
            margin-bottom: 15px;
        }

        .login-box .input-group i {
            margin-right: 10px;
            color: #666666;
        }

        .login-box .input-group input {
            flex: 1;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: var(--input-background-color);
            color: var(--text-color);
        }

        .login-box button {
            background-color: var(--button-background-color);
            color: #ffffff;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: auto;
        }

        .login-box button:hover {
            background-color: var(--button-hover-color);
        }

        .login-box a {
            color: var(--link-color);
            text-decoration: none;
            display: block;
            margin-top: 10px;
        }

        .login-box a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <button class="theme-toggle" onclick="toggleTheme()">
        <i class="fas fa-adjust"></i> Alternar Tema
    </button>
    <div class="login-box">
        <h1>Conta Veio</h1>
        <h2>Login do Responsável</h2>
        <form method="POST">
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="senha" placeholder="Senha" required>
            </div>
            <button type="submit"><i class="fas fa-sign-in-alt"></i> Entrar</button>
            <a href="cadastro_responsavel.php"><i class="fas fa-user-plus"></i> Cadastrar Responsável</a>
        </form>
    </div>

    <script>
        function toggleTheme() {
            const currentTheme = document.body.getAttribute('data-theme');
            if (currentTheme === 'dark') {
                document.body.removeAttribute('data-theme');
                localStorage.setItem('theme', 'light');
            } else {
                document.body.setAttribute('data-theme', 'dark');
                localStorage.setItem('theme', 'dark');
            }
        }


        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'dark') {
            document.body.setAttribute('data-theme', 'dark');
        }
    </script>
</body>
</html>
