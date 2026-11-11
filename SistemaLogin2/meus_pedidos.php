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

$usuario_id = (int) $_SESSION['usuario_id'];

$sql = "
    SELECT
        p.id AS pedido_id,
        p.valor_total,
        p.forma_pagamento,
        p.status,
        p.criado_em,
        i.quantidade,
        i.preco_unitario,
        pr.nome AS produto_nome
    FROM pedidos p
    LEFT JOIN itens_pedido i
        ON i.pedido_id = p.id
    LEFT JOIN produtos pr
        ON pr.id = i.produto_id
    WHERE p.usuario_id = ?
    ORDER BY p.criado_em DESC, p.id DESC, i.id ASC
";

$stmt = $conexao->prepare($sql);
$stmt->execute([$usuario_id]);

$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pedidos = [];

foreach ($resultados as $linha) {
    $id = $linha['pedido_id'];

    if (!isset($pedidos[$id])) {
        $pedidos[$id] = [
            'id' => $id,
            'valor_total' => $linha['valor_total'],
            'forma_pagamento' => $linha['forma_pagamento'],
            'status' => $linha['status'],
            'criado_em' => $linha['criado_em'],
            'itens' => []
        ];
    }

    if ($linha['produto_nome'] !== null) {
        $pedidos[$id]['itens'][] = [
            'nome' => $linha['produto_nome'],
            'quantidade' => $linha['quantidade'],
            'preco_unitario' => $linha['preco_unitario']
        ];
    }
}

function escapar($valor) {
    return htmlspecialchars(
        (string) $valor,
        ENT_QUOTES,
        'UTF-8'
    );
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Meus Pedidos - Zeta Transporte</title>

    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        body {
            background: #f4f6f9;
            font-family: Arial, sans-serif;
            margin: 0;
        }

        .pedidos-container {
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
        }

        .titulo {
            text-align: center;
            margin-bottom: 35px;
            color: #1e293b;
        }

        .pedido-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        .pedido-topo {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .pedido-topo h2 {
            color: #1677d2;
            margin: 0;
        }

        .status {
            background: #fff3cd;
            color: #856404;
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: bold;
        }

        .produto {
            padding: 12px 0;
            border-bottom: 1px solid #eee;
        }

        .produto strong {
            color: #333;
        }

        .detalhes {
            margin-top: 20px;
            line-height: 1.8;
        }

        .valor-total {
            font-size: 24px;
            color: #16803c;
            font-weight: bold;
        }

        .vazio {
            background: white;
            padding: 40px;
            text-align: center;
            border-radius: 12px;
        }

        .btn {
            display: inline-block;
            padding: 12px 22px;
            background: #1677d2;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin-top: 20px;
        }

        .btn:hover {
            background: #105ba2;
        }

        @media (max-width: 600px) {
            .pedidos-container {
                margin: 20px auto;
            }

            .pedido-card {
                padding: 18px;
            }
        }
    </style>
</head>

<body>

<main class="pedidos-container">

    <h1 class="titulo">Meus Pedidos</h1>

    <?php if (empty($pedidos)): ?>

        <div class="vazio">
            <h2>Você ainda não realizou pedidos.</h2>

            <p>Confira nossos produtos disponíveis!</p>

            <a href="produtos.php" class="btn">
                Ver Produtos
            </a>
        </div>

    <?php else: ?>

        <?php foreach ($pedidos as $pedido): ?>

            <div class="pedido-card">

                <div class="pedido-topo">

                    <h2>
                        Pedido #<?= (int)$pedido['id'] ?>
                    </h2>

                    <span class="status">
                        <?= escapar($pedido['status']) ?>
                    </span>

                </div>

                <p>
                    <strong>Data:</strong>
                    <?= date(
                        'd/m/Y H:i',
                        strtotime($pedido['criado_em'])
                    ) ?>
                </p>

                <h3>Produtos comprados</h3>

                <?php foreach ($pedido['itens'] as $item): ?>

                    <div class="produto">

                        <strong>
                            <?= escapar($item['nome']) ?>
                        </strong>

                        <p>
                            Quantidade:
                            <?= (int)$item['quantidade'] ?>
                        </p>

                        <p>
                            Preço unitário:
                            R$ <?= number_format(
                                (float)$item['preco_unitario'],
                                2,
                                ',',
                                '.'
                            ) ?>
                        </p>

                    </div>

                <?php endforeach; ?>

                <div class="detalhes">

                    <p>
                        <strong>Pagamento:</strong>
                        <?= escapar($pedido['forma_pagamento']) ?>
                    </p>

                    <p>
                        <strong>Status:</strong>
                        <?= escapar($pedido['status']) ?>
                    </p>

                    <p>
                        <strong>Valor total:</strong>
                    </p>

                    <p class="valor-total">
                        R$ <?= number_format(
                            (float)$pedido['valor_total'],
                            2,
                            ',',
                            '.'
                        ) ?>
                    </p>

                </div>

            </div>

        <?php endforeach; ?>

    <?php endif; ?>

    <a href="dashboard.php" class="btn">
        Voltar ao Painel
    </a>

</main>

</body>
</html>
