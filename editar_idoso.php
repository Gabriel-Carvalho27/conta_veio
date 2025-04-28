<?php
include 'conexao.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID do idoso não fornecido ou inválido.";
    exit;
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM idosos WHERE id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo "Erro na preparação da consulta: " . $conn->error;
    exit;
}

$stmt->bind_param("i", $id);

if (!$stmt->execute()) {
    echo "Erro ao executar a consulta: " . $stmt->error;
    exit;
}

$resultado = $stmt->get_result();

if ($resultado->num_rows == 0) {
    echo "Idoso não encontrado.";
    exit;
}

$idoso = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Idoso</title>
    <style>
        body {
            font-family: Arial, sans-serif; background-color: #f2f2f2; padding: 20px;
        }
        .form-container {
            background-color: #fff; padding: 20px; border-radius: 10px; max-width: 500px; margin: auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        input, select {
            width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px;
        }
        button {
            background-color: #007BFF; color: #fff; border: none; padding: 10px 20px;
            border-radius: 5px; cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Editar Informações do Idoso</h2>
    <form action="atualizar_idoso.php" method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($idoso['id']) ?>">

        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($idoso['nome']) ?>" required autocomplete="off">

        <label for="data_nascimento">Data de Nascimento:</label>
        <input type="date" id="data_nascimento" name="data_nascimento" value="<?= htmlspecialchars($idoso['data_nascimento']) ?>" required>

        <label for="cpf">CPF:</label>
        <input type="text" id="cpf" name="cpf" value="<?= htmlspecialchars($idoso['cpf']) ?>" required autocomplete="off">

        <label for="endereco">Endereço:</label>
        <input type="text" id="endereco" name="endereco" value="<?= htmlspecialchars($idoso['endereco']) ?>" autocomplete="off">

        <label for="telefone">Telefone:</label>
        <input type="text" id="telefone" name="telefone" value="<?= htmlspecialchars($idoso['telefone']) ?>" autocomplete="off">

        <button type="submit">Atualizar</button>
    </form>
</div>

</body>
</html>
