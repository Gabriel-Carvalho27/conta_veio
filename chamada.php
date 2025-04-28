<?php
session_start();
require_once "conexao.php";


if (!isset($_SESSION["logado"])) {
    header("Location: index.php");
    exit;
}

date_default_timezone_set('America/Sao_Paulo');

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) && $_POST["action"] === "registrar_chamada") {
    $idoso_id = intval($_POST["idoso_id"]);
    $status = $_POST["status"];
    $data = date("Y-m-d");
    $hora = date("H:i:s");

    $stmt = $conn->prepare("INSERT INTO chamadas (idoso_id, data_chamada, hora_chamada, status) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $idoso_id, $data, $hora, $status);
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Chamada registrada!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Erro ao registrar chamada."]);
    }
    $stmt->close();
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chamada de Idosos</title>
    <link rel="stylesheet" href="css/style.css">
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

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 545px;
            background-color: var(--box-background-color);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .top-bar input {
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: var(--input-background-color);
            color: var(--text-color);
        }

        .top-bar a, .top-bar button {
            margin-left: 10px;
            background-color: var(--button-background-color);
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .top-bar a:hover, .top-bar button:hover {
            background-color: var(--button-hover-color);
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: var(--box-background-color);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .container h2 {
            margin-bottom: 20px;
        }

        .idoso {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 5px 10px;
            margin-bottom: 10px;
            background-color: var(--input-background-color);
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .idoso:hover {
            transform: scale(1.02);
        }

        .idoso-info {
            flex: 1;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .idoso strong {
            font-size: 1.2em;
        }

        .idade {
            min-width: 80px;
            text-align: center;
        }

        .idoso button {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.5em;
            transition: transform 0.2s;
        }

        .idoso button:hover {
            transform: scale(1.2);
        }

        .idoso button.presente i {
            color: #28a745;
        }

        .idoso button.ausente i {
            color: #dc3545;
        }
    </style>
</head>
<body>
    <button class="theme-toggle" onclick="toggleTheme()">
        <i class="fas fa-adjust"></i>
    </button>

    <div class="top-bar">
        <input type="text" id="busca" placeholder="Buscar idoso...">
        <a href="cadastro_idoso.php"><i class="fas fa-user-plus"></i> Cadastrar Novo Idoso</a>
        <a href="relatorios.php"><i class="fas fa-file-alt"></i> Relatórios</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a>
    </div>

    <div class="container">
        <h2>Chamada de Hoje - <?php echo date("d/m/Y"); ?></h2>
        <?php
        $sql = "SELECT * FROM idosos ORDER BY nome";
        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {
            $nome = htmlspecialchars($row['nome']);
            $idade = intval($row['idade']);
            $id = intval($row['id']);

            echo "<div class='idoso'>";
            echo "<div class='idoso-info'>";
            echo "<strong>$nome</strong>";
            echo "<span class='idade'>$idade anos</span>";
            echo "</div>";
            echo "<div>";
            echo "<button class='presente' onclick='registrarChamada($id, \"Presente\")' title='Marcar como Presente'><i class='fas fa-check-circle'></i></button>";
            echo "<button class='ausente' onclick='registrarChamada($id, \"Ausente\")' title='Marcar como Ausente'><i class='fas fa-times-circle'></i></button>";
            echo "</div>";
            echo "</div>";
        }

        $conn->close();
        ?>
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

        function registrarChamada(idosoId, status) {
            fetch('', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    action: 'registrar_chamada',
                    idoso_id: idosoId,
                    status: status
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("✅ " + data.message);
                } else {
                    alert("❌ " + data.message);
                }
            })
            .catch(error => {
                console.error("Erro:", error);
                alert("❌ Erro ao registrar chamada.");
            });
        }
    </script>
</body>
</html>
