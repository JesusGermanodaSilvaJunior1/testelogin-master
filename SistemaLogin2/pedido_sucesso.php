<?php
/*
 * Projeto: Zeta Transporte
 * Desenvolvedor: Arthur Lázaro
 * Ano: 2026
 */
session_start();
require_once __DIR__ . "/config/conexao.php";

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    header("Location: produtos.php");
    exit;
}

$stmt = $conexao->prepare(
    "SELECT * FROM pedidos WHERE id = ? AND usuario_id = ?"
);

$stmt->execute([
    $id,
    $_SESSION['usuario_id']
]);

$pedido = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pedido) {
    http_response_code(404);
    die("Pedido não encontrado.");
}

function escapar($valor) {
    return htmlspecialchars((string)$valor, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido Registrado - Zeta Transporte</title>
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        body {
            background: #f4f6f9;
            font-family: Arial, sans-serif;
        }

        .sucesso {
            max-width: 550px;
            margin: 80px auto;
            padding: 40px;
            text-align: center;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        h1 {
            color: #16803c;
        }

        .valor {
            font-size: 26px;
            font-weight: bold;
            color: #16803c;
        }

        .botao {
            display: inline-block;
            padding: 12px 25px;
            background: #1677d2;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="sucesso">

    <h1>Pedido registrado com sucesso!</h1>

    <p>Seu pedido foi salvo no sistema.</p>

    <p>
        <strong>Número do pedido:</strong>
        #<?= (int)$pedido['id'] ?>
    </p>

    <p>
        <strong>Forma de pagamento:</strong>
        <?= escapar($pedido['forma_pagamento']) ?>
    </p>

    <p>
        <strong>Status:</strong>
        <?= escapar($pedido['status']) ?>
    </p>

    <p class="valor">
        R$ <?= number_format((float)$pedido['valor_total'], 2, ',', '.') ?>
    </p>

    <p>Pagamento ainda não realizado.</p>

    <a class="botao" href="produtos.php">
        Continuar comprando
    </a>

</div>

</body>
</html>
