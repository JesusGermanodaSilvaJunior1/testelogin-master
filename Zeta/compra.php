<?php 
    session_start();
    include 'conexao.php';

    $id = (int) ($_GET['id'] ?? 0);

    $stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ? AND ativo = 1");
    $stmt->execute([$id]);
    $produto = $stmt->fetch();

    if (!$produto) {
        header("Location: index.php");
        exit;
    }

    $em_promocao = $produto['preco_promocional'] !== null;
    $preco_final = $em_promocao ? $produto['preco_promocional'] : $produto['preco'];

    $_SESSION['csrf'] = bin2hex(random_bytes(16));
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Vitor Alves Vieira Santos">
    <link rel="stylesheet" href="style.css">
    <title>Comprar - Zeta Transporte</title>
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
            <h2><?= htmlspecialchars($produto['nome']) ?></h2>
            <img src="img/<?= htmlspecialchars($produto['imagem']) ?>" alt="<?= htmlspecialchars($produto['nome']) ?>">
            <p><?= htmlspecialchars($produto['descricao']) ?></p>

            <?php if ($em_promocao): ?>
                <p class="preco-antigo">De R$ <?= number_format($produto['preco'], 2, ',', '.') ?></p>
                <p class="selo">Promoção</p>
            <?php endif; ?>
            <p class="preco">R$ <?= number_format($preco_final, 2, ',', '.') ?></p>

            <form action="finalizar.php" method="post">
                <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
                <input type="hidden" name="produto_id" value="<?= (int) $produto['id'] ?>">

                <label for="nome">Nome completo</label>
                <input type="text" id="nome" name="nome" maxlength="120" required>

                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" maxlength="150" required>

                <label for="forma">Forma de pagamento</label>
                <select id="forma" name="forma_pagamento" required>
                    <option value="pix">PIX (em até 12x)</option>
                    <option value="cartao">Cartão de crédito (em até 6x sem juros)</option>
                </select>

                <label for="parcelas">Parcelas</label>
                <select id="parcelas" name="parcelas" required></select>

                <label for="gateway">Pagar com</label>
                <select id="gateway" name="gateway" required>
                    <option value="mercadopago">Mercado Pago</option>
                    <option value="paypal">PayPal</option>
                    <option value="santander">Santander</option>
                </select>

                <button type="submit" class="botao">Finalizar compra</button>
            </form>
        </section>
    </main>

    <footer>
        <p>
            Av. dos Gansos Pretos, 10040 – Bairro Nova Esperança – Belém/PA – Brasil<br>
            Telefone: (31) 3201-1527<br>
            CNPJ: 45.345.496/0001-05
        </p>
    </footer>

    <script>
        var valor = <?= json_encode((float) $preco_final) ?>;
        var forma = document.getElementById("forma");
        var parcelas = document.getElementById("parcelas");

        function montarParcelas() {
            var maximo = forma.value === "pix" ? 12 : 6;
            parcelas.innerHTML = "";
            for (var i = 1; i <= maximo; i++) {
                var texto = i + "x de R$ " + (valor / i).toFixed(2).replace(".", ",");
                parcelas.add(new Option(texto, i));
            }
        }

        forma.addEventListener("change", montarParcelas);
        montarParcelas();
    </script>
</body>
</html>
