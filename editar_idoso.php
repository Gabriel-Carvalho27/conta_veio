<?php
session_start();
require_once "conexao.php";

if (!isset($_SESSION["logado"])) {
    header("Location: index.php");
    exit;
}

if (!isset($_GET["id"])) {
    header("Location: chamada.php");
    exit;
}

$id = intval($_GET["id"]);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST["nome"]);
    $idade = intval($_POST["idade"]);
    $cpf = trim($_POST["cpf"]);
    $telefone = trim($_POST["telefone"]);
    $endereco = trim($_POST["endereco"]);
    $observacoes = trim($_POST["observacoes"]);

    $stmt = $conn->prepare("UPDATE idosos SET nome = ?, idade = ?, cpf = ?, telefone = ?, endereco = ?, observacoes = ? WHERE id = ?");
    $stmt->bind_param("sissssi", $nome, $idade, $cpf, $telefone, $endereco, $observacoes, $id);

    if ($stmt->execute()) {
        header("Location: chamada.php");
        exit;
    } else {
        $erro = "Erro ao atualizar idoso.";
    }
}

$stmt = $conn->prepare("SELECT * FROM idosos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$idoso = $result->fetch_assoc();
$stmt->close();

if (!$idoso) {
    echo "Idoso não encontrado.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Idoso</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --background-color: #f0f4f8;
            --text-color: #333;
            --box-background-color: #fff;
            --input-background-color: #e0e0e0;
            --button-background-color: #007bff;
            --button-hover-color: #0056b3;
            --link-color: #007bff;
        }

        [data-theme="dark"] {
            --background-color: #121212;
            --text-color: #fff;
            --box-background-color: #1e1e1e;
            --input-background-color: #333;
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
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .theme-toggle:hover {
            background-color: var(--button-hover-color);
        }

        .container {
            max-width: 700px;
            margin: 50px auto;
            padding: 20px;
            background-color: var(--box-background-color);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .container h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        textarea {
            padding: 10px;
            margin-bottom: 20px;
            border: none;
            border-radius: 5px;
            background-color: var(--input-background-color);
            color: var(--text-color);
            resize: vertical;
        }

        button {
            padding: 10px;
            background-color: var(--button-background-color);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: var(--button-hover-color);
        }

        .voltar {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: var(--link-color);
            text-decoration: none;
            font-weight: bold;
        }

        .voltar:hover {
            text-decoration: underline;
        }

        .erro {
            color: red;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <button class="theme-toggle" onclick="toggleTheme()">
        <i class="fas fa-adjust"></i>
    </button>

    <div class="container">
        <h1>Editar Cadastro do Idoso</h1>

        <?php if (isset($erro)) echo "<p class='erro'>$erro</p>"; ?>

        <form method="POST">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" value="<?php echo htmlspecialchars($idoso['nome']); ?>" required>

            <label for="idade">Idade:</label>
            <input type="number" name="idade" id="idade" value="<?php echo intval($idoso['idade']); ?>" required>

            <label for="cpf">CPF:</label>
            <input type="text" name="cpf" id="cpf" value="<?php echo htmlspecialchars($idoso['cpf']); ?>" required>

            <label for="telefone">Telefone:</label>
            <input type="text" name="telefone" id="telefone" value="<?php echo htmlspecialchars($idoso['telefone']); ?>" required>

            <label for="endereco">Endereço:</label>
            <input type="text" name="endereco" id="endereco" value="<?php echo htmlspecialchars($idoso['endereco']); ?>" required>

            <label for="observacoes">Observações:</label>
            <textarea name="observacoes" id="observacoes" rows="4"><?php echo htmlspecialchars($idoso['observacoes']); ?></textarea>

            <button type="submit">Salvar Alterações</button>
        </form>

        <a href="chamada.php" class="voltar">← Voltar</a>
    </div>

    <script>
        function toggleTheme() {
            const body = document.body;
            const currentTheme = body.getAttribute('data-theme');
            body.setAttribute('data-theme', currentTheme === 'dark' ? '' : 'dark');
            localStorage.setItem('theme', currentTheme === 'dark' ? 'light' : 'dark');
        }

        if (localStorage.getItem('theme') === 'dark') {
            document.body.setAttribute('data-theme', 'dark');
        }
    </script>
</body>
</html>
