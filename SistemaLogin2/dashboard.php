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

$usuario = htmlspecialchars($_SESSION['usuario']);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name"author" content="Arthur Lazaro">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel - Zeta Transporte</title>

    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        .painel-container {
            max-width: 900px;
            margin: 60px auto;
            padding: 35px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.10);
            text-align: center;
        }

        .painel-container h1 {
            color: #e63946;
        }

        .painel-links {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 30px;
        }

        .painel-links a {
            padding: 14px 22px;
            background: #e63946;
            color: white;
            text-decoration: none;
            border-radius: 8px;
        }

        .painel-links a:hover {
            background: #bd2634;
        }
    </style>
</head>

<body>

<header>
    <div class="logo">ZETA <span>TRANSPORTE</span></div>
</header>

<main class="painel-container">

    <h1>Bem-vindo à Zeta Transporte!</h1>

    <h2>Olá, <?= $usuario ?>!</h2>

    <p>Você entrou no sistema com sucesso.</p>

    <div class="painel-links">
        <a href="produtos.php">Ver produtos</a>
        <a href="curriculos_admin.php">Ver currículos</a>
        <a href="logout.php">Sair da conta</a>
        <a href="meus_pedidos.php">Meus Pedidos</a>
    </div>

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
