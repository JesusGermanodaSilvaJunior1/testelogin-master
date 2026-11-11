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
    header("Location: meus_pedidos.php");
    exit;
}

$stmt = $conexao->prepare(
    "SELECT * FROM pedidos
     WHERE id = ? AND usuario_id = ?"
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

if (empty($_SESSION['csrf_pagamento'])) {
    $_SESSION['csrf_pagamento'] =
        bin2hex(random_bytes(32));
}

function escapar($valor) {
    return htmlspecialchars(
        (string)$valor,
        ENT_QUOTES,
        'UTF-8'
    );
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Confirmar Pagamento - Zeta Transporte</title>

    <style>
        body {
            background: #f4f6f9;
            font-family: Arial, sans-serif;
            margin: 0;
        }

        .caixa {
            max-width: 550px;
            margin: 60px auto;
            background: white;
            padding: 35px;
            border-radius: 14px;
            box-shadow: 0 4px 18px rgba(0,0,0,.1);
            box-sizing: border-box;
        }

        h1 {
            color: #087eaa;
            text-align: center;
        }

        .aviso {
            background: #fff3cd;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
        }

        .valor {
            color: #16803c;
            font-size: 28px;
            font-weight: bold;
        }

        button {
            width: 100%;
            padding: 15px;
            background: #d62828;
            color: white;
            border: none;
            border-radius: 9px;
            font-size: 17px;
            cursor: pointer;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<main class="caixa">

    <h1>Confirmar Pagamento</h1>

    <p class="aviso">
        Simulação acadêmica.
        Nenhum dinheiro será movimentado.
    </p>

    <p>
        <strong>Pedido:</strong>
        #<?= (int)$pedido['id'] ?>
    </p>

    <p>
        <strong>Forma de pagamento:</strong>
        <?= escapar($pedido['forma_pagamento']) ?>
    </p>

    <p>
        <strong>Parcelas:</strong>
        <?= (int)$pedido['parcelas'] ?>x
    </p>

    <p>
        <strong>Valor aproximado da parcela:</strong>
        R$ <?= number_format(
            (float)$pedido['valor_parcela'],
            2, ',', '.'
        ) ?>
    </p>

    <p><strong>Total:</strong></p>

    <p class="valor">
        R$ <?= number_format(
            (float)$pedido['valor_total'],
            2, ',', '.'
        ) ?>
    </p>

    <p>
        <strong>Status atual:</strong>
        <?= escapar($pedido['status']) ?>
    </p>

    <?php if ($pedido['status'] === 'Pendente'): ?>

        <form action="processar_pagamento.php" method="POST">

            <input
                type="hidden"
                name="pedido_id"
                value="<?= (int)$pedido['id'] ?>"
            >

            <input
                type="hidden"
                name="csrf"
                value="<?= escapar($_SESSION['csrf_pagamento']) ?>"
            >

            <button type="submit">
                Confirmar Pagamento Simulado
            </button>

        </form>

    <?php else: ?>

        <p>Este pedido já foi processado.</p>

    <?php endif; ?>

    <a href="meus_pedidos.php">
        Ver meus pedidos
    </a>

</main>

</body>
</html>
