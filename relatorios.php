<?php
include "conexao.php";
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Relatórios de Chamada</title>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <style>
        :root {
            --background-color: #f0f4f8;
            --text-color: #333;
            --box-bg: #fff;
            --input-bg: #e0e0e0;
            --btn-bg: #007bff;
            --btn-hover: #0056b3;
            --link-color: #007bff;
        }

        [data-theme="dark"] {
            --background-color: #121212;
            --text-color: #fff;
            --box-bg: #1e1e1e;
            --input-bg: #333;
            --btn-bg: #4444ff;
            --btn-hover: #3333cc;
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
            background-color: var(--btn-bg);
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .theme-toggle:hover {
            background-color: var(--btn-hover);
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: var(--box-bg);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .top-bar input {
            padding: 8px;
            border: none;
            border-radius: 5px;
            background-color: var(--input-bg);
            color: var(--text-color);
        }

        .top-bar a {
            color: var(--link-color);
            text-decoration: none;
            margin-left: 10px;
        }

        .top-bar a:hover {
            text-decoration: underline;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: var(--box-bg);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 20px;
        }

        .container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }

        table th {
            background-color: var(--input-bg);
        }

        table tr:hover {
            background-color: var(--input-bg);
        }

        .btn-actions {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            gap: 10px;
        }

        .btn-small {
            background-color: var(--btn-bg);
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-small:hover {
            background-color: var(--btn-hover);
        }
    </style>
</head>
<body>
    <button class="theme-toggle" onclick="toggleTheme()">
        <i class="fas fa-adjust"></i> Alternar Tema
    </button>

    <div class="top-bar">
        <input type="text" id="busca" placeholder="Buscar idoso..." onkeyup="filtrarTabela()" />
        <a href="cadastro_idoso.php"><i class="fas fa-user-plus"></i> Cadastrar Novo Idoso</a>
        <a href="chamada.php"><i class="fas fa-clipboard-list"></i> Chamada</a>
    </div>

    <div class="container" id="relatorio">
        <h2>Relatórios de Presença</h2>
        <table>
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Horário</th>
                    <th>Nome do Idoso</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="tabela-corpo">
                <?php
                $sql = "SELECT c.data_chamada, c.hora_chamada, i.nome, c.status
                        FROM chamadas c
                        JOIN idosos i ON c.idoso_id = i.id
                        ORDER BY c.data_chamada DESC, c.hora_chamada DESC";
                $result = $conn->query($sql);

                while ($row = $result->fetch_assoc()) {
                    $data = date("d/m/Y", strtotime($row['data_chamada']));
                    $hora = date("H:i", strtotime($row['hora_chamada']));

                    echo "<tr class='idoso'>";
                    echo "<td>$data</td>";
                    echo "<td>$hora</td>";
                    echo "<td>{$row['nome']}</td>";
                    echo "<td>{$row['status']}</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="btn-actions">
        <button class="btn-small" onclick="gerarPDF()">
            <i class="fas fa-file-pdf"></i> Baixar Relatório em PDF
        </button>
        <a href="chamada.php" class="btn-small">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script>
        function toggleTheme() {
            const body = document.body;
            const currentTheme = body.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

            if (newTheme === 'light') {
                body.removeAttribute('data-theme');
            } else {
                body.setAttribute('data-theme', 'dark');
            }

            localStorage.setItem('theme', newTheme);
        }

        (function () {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark') {
                document.body.setAttribute('data-theme', 'dark');
            }
        })();

        async function gerarPDF() {
            const { jsPDF } = window.jspdf;

            const elemento = document.querySelector("#relatorio");
            const canvas = await html2canvas(elemento, { scale: 2 });

            const imgData = canvas.toDataURL("image/png");
            const pdf = new jsPDF("p", "mm", "a4");

            const imgProps = pdf.getImageProperties(imgData);
            const pdfWidth = pdf.internal.pageSize.getWidth();
            const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

            pdf.addImage(imgData, "PNG", 0, 0, pdfWidth, pdfHeight);
            pdf.save("relatorio_chamada.pdf");
        }

        function filtrarTabela() {
            const input = document.getElementById('busca');
            const filtro = input.value.toLowerCase();
            const linhas = document.querySelectorAll('#tabela-corpo tr');

            linhas.forEach((linha) => {
                const nome = linha.cells[2].textContent.toLowerCase();
                linha.style.display = nome.includes(filtro) ? '' : 'none';
            });
        }
    </script>
</body>
</html>
