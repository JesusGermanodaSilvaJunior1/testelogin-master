<?php
/*
 * Projeto: Zeta Transporte
 * Desenvolvedor: Arthur Lázaro
 * Ano: 2026
 */
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . "/config/conexao.php";

$sql = "SELECT * FROM curriculos ORDER BY enviado_em DESC";
$stmt = $conexao->query($sql);
$curriculos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name"author" content="Arthur Lazaro">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Currículos Recebidos - Zeta Transporte</title>

    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        .admin-container {
            max-width: 1100px;
            margin: 50px auto;
            padding: 25px;
        }

        .admin-container h1 {
            margin-bottom: 25px;
        }

        .tabela-container {
            overflow-x: auto;
            background: white;
            border-radius: 12px;
            padding: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.10);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 650px;
        }

        th, td {
            padding: 14px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #172033;
            color: white;
        }

        .botao-pdf {
            display: inline-block;
            padding: 9px 14px;
            background: #e63946;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }

        .vazio {
            background: white;
            padding: 25px;
            border-radius: 10px;
        }

        .voltar {
            display: inline-block;
            margin-top: 25px;
            color: #e63946;
            text-decoration: none;
        }
    </style>
</head>

<body>

<header>
    <div class="logo">ZETA <span>TRANSPORTE</span></div>
    <nav>
        <a href="dashboard.php">Painel</a>
        <a href="index.php">Início</a>
        <a href="logout.php">Sair</a>
    </nav>
</header>

<main class="admin-container">

    <h1>Currículos Recebidos</h1>

    <p>Bem-vindo, <?= htmlspecialchars($_SESSION['usuario']) ?>!</p>

    <?php if (count($curriculos) > 0): ?>

        <div class="tabela-container">

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Telefone</th>
                        <th>Data de envio</th>
                        <th>Currículo</th>
                    </tr>
                </thead>

                <tbody>

                    <?php foreach ($curriculos as $curriculo): ?>

                        <tr>
                            <td><?= (int)$curriculo['id'] ?></td>

                            <td>
                                <?= htmlspecialchars($curriculo['nome']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($curriculo['email']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($curriculo['telefone'] ?? '') ?>
                            </td>

                            <td>
                                <?= date('d/m/Y H:i', strtotime($curriculo['enviado_em'])) ?>
                            </td>

                            <td>
                                <a class="botao-pdf"
                                   href="baixar_curriculo.php?id=<?= (int)$curriculo['id'] ?>">
                                    Baixar PDF
                                </a>
                            </td>
                        </tr>

                    <?php endforeach; ?>

                </tbody>
            </table>

        </div>

    <?php else: ?>

        <div class="vazio">
            Nenhum currículo foi enviado ainda.
        </div>

    <?php endif; ?>

    <a class="voltar" href="dashboard.php">
        ← Voltar ao painel
    </a>

</main>

<footer>
    <h3>Zeta Transporte</h3>

    <p>
        Avenida dos Gansos Pretos, 10040 -
        Nova Esperança - Belém - Pará - Brasil
    </p>

    <p>Telefone: (31) 3201-1527</p>

    <p>CNPJ: 45.345.496/0001-05</p>

    <p>
        © 2026 Zeta Transporte -
        Todos os direitos reservados.
    </p>

    <p>
        Desenvolvido por Arthur Lázaro
    </p>
</footer>

</body>
</html>
