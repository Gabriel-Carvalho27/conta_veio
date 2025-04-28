<?php
include "conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $idade = $_POST["idade"];
    $cpf = $_POST["cpf"];
    $telefone = $_POST["telefone"];
    $endereco = $_POST["endereco"];
    $observacoes = $_POST["observacoes"];

    $stmt = $conn->prepare("INSERT INTO idosos (nome, idade, cpf, telefone, endereco, observacoes) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sissss", $nome, $idade, $cpf, $telefone, $endereco, $observacoes);
    $stmt->execute();
    $stmt->close();

    header("Location: chamada.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Idoso - Conta Veio</title>
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

        .form-box {
            background-color: var(--box-background-color);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 20px;
            max-width: 450px;
            margin: 100px auto;
            text-align: center;
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
            margin-right: 10px;
            color: #666666;
        }

        .form-box .input-group input,
        .form-box .input-group textarea {
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
            margin-top: 10px;
        }

        .form-box button:hover {
            background-color: var(--button-hover-color);
        }

        .back-button {
            margin-top: 15px;
            background-color: #6c757d;
        }

        .back-button:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <button class="theme-toggle" onclick="toggleTheme()">
        <i class="fas fa-adjust"></i> Alternar Tema
    </button>
    <div class="form-box">
        <h2>Cadastrar Idoso</h2>
        <form method="POST">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="nome" placeholder="Nome completo" required>
            </div>
            <div class="input-group">
                <i class="fas fa-calendar-alt"></i>
                <input type="number" name="idade" placeholder="Idade" required>
            </div>
            <div class="input-group">
                <i class="fas fa-id-card"></i>
                <input type="text" name="cpf" placeholder="CPF" required>
            </div>
            <div class="input-group">
                <i class="fas fa-phone"></i>
                <input type="text" name="telefone" placeholder="Telefone" required>
            </div>
            <div class="input-group">
                <i class="fas fa-map-marker-alt"></i>
                <input type="text" name="endereco" placeholder="Endereço" required>
            </div>
            <div class="input-group">
                <i class="fas fa-sticky-note"></i>
                <textarea name="observacoes" placeholder="Observações"></textarea>
            </div>
            <button type="submit"><i class="fas fa-save"></i> Cadastrar</button>
        </form>


        <a href="chamada.php">
            <button class="back-button"><i class="fas fa-arrow-left"></i> Voltar</button>
        </a>
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
