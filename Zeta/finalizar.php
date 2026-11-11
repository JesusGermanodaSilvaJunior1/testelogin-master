<?php 
    session_start();
    include 'conexao.php';

    $erro = "";
    $pedido_id = 0;
    $valor_total = 0;

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: index.php");
        exit;
    }

    $csrf       = $_POST['csrf'] ?? '';
    $produto_id = (int) ($_POST['produto_id'] ?? 0);
    $nome       = trim($_POST['nome'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $forma      = $_POST['forma_pagamento'] ?? '';
    $parcelas   = (int) ($_POST['parcelas'] ?? 0);
    $gateway    = $_POST['gateway'] ?? '';

    $maximo_parcelas = $forma === 'pix' ? 12 : 6;

    if (!hash_equals($_SESSION['csrf'] ?? '', $csrf)) {
        $erro = "Sessão expirada. Volte e tente novamente.";
    } elseif ($nome === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = "Preencha nome e e-mail corretamente.";
    } elseif (!in_array($forma, ['pix', 'cartao'], true)) {
        $erro = "Forma de pagamento inválida.";
    } elseif (!in_array($gateway, ['mercadopago', 'paypal', 'santander'], true)) {
        $erro = "Meio de pagamento inválido.";
    } elseif ($parcelas < 1 || $parcelas > $maximo_parcelas) {
        $erro = "Número de parcelas inválido.";
    }

    if ($erro === "") {
        $stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ? AND ativo = 1");
        $stmt->execute([$produto_id]);
        $produto = $stmt->fetch();

        if (!$produto) {
            $erro = "Produto não encontrado.";
        } else {
            $valor_total = $produto['preco_promocional'] !== null ? $produto['preco_promocional'] : $produto['preco'];

            $stmt = $pdo->prepare(
                "INSERT INTO pedidos (produto_id, nome_cliente, email_cliente, forma_pagamento, parcelas, gateway, valor_total)
                 VALUES (?, ?, ?, ?, ?, ?, ?)"
            );
            $stmt->execute([$produto_id, $nome, $email, $forma, $parcelas, $gateway, $valor_total]);
            $pedido_id = $pdo->lastInsertId();
            unset($_SESSION['csrf']);
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Pedido - Zeta Transporte</title>
</head>
<body>
    <header>
        <h1>Zeta Transporte</h1>
        <nav>
            <a href="index.php">Início</a>
            <a href="index.php#produtos">Produtos</a>
            <a href="contato.php">Trabalhe Conosco</a>
        </nav>
    </header>

    <main>
        <section class="compra">
            <?php if ($erro !== ""): ?>
                <h2>Não foi possível finalizar</h2>
                <p class="mensagem erro"><?= htmlspecialchars($erro) ?></p>
                <a class="botao" href="index.php#produtos">Voltar aos produtos</a>
            <?php else: ?>
                <h2>Pedido #<?= (int) $pedido_id ?> registrado</h2>
                <p><?= htmlspecialchars($produto['nome']) ?></p>
                <p class="preco">
                    <?= $parcelas ?>x de R$ <?= number_format($valor_total / $parcelas, 2, ',', '.') ?>
                </p>
                <p>Total: R$ <?= number_format($valor_total, 2, ',', '.') ?></p>
                <p>Pagamento: <?= $forma === 'pix' ? 'PIX' : 'Cartão de crédito' ?> via <?= htmlspecialchars($gateway) ?></p>
                <p class="mensagem">Pedido salvo com status pendente. A cobrança será ligada ao gateway na próxima etapa.</p>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        <p>
            Av. dos Gansos Pretos, 10040 – Bairro Nova Esperança – Belém/PA – Brasil<br>
            Telefone: (31) 3201-1527<br>
            CNPJ: 45.345.496/0001-05
        </p>
    </footer>
</body>
</html>
