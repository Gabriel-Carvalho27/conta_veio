<?php
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $data_nascimento = $_POST['data_nascimento'];
    $cpf = $_POST['cpf'];
    $endereco = $_POST['endereco'];
    $telefone = $_POST['telefone'];

    $sql = "UPDATE idosos SET nome=?, data_nascimento=?, cpf=?, endereco=?, telefone=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $nome, $data_nascimento, $cpf, $endereco, $telefone, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Idoso atualizado com sucesso!'); window.location.href='index.php';</script>";
    } else {
        echo "Erro ao atualizar: " . $stmt->error;
    }
}
?>
