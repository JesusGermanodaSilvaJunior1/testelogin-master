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

if (!$id || $id < 1) {
    header("Location: produtos.php");
    exit;
}

$stmt = $conexao->prepare(
    "SELECT * FROM produtos WHERE id = ?"
);
$stmt->execute([$id]);

$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto) {
    die("Produto não encontrado.");
}

$preco = (
    isset($produto['preco_promocional']) &&
    $produto['preco_promocional'] !== null &&
    $produto['preco_promocional'] !== ''
)
    ? $produto['preco_promocional']
    : $produto['preco'];

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

    <title>Pagamento - Zeta Transporte</title>
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f3f5f8;
        }

        .container {
            max-width: 680px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 14px;
            box-shadow: 0 5px 20px rgba(0,0,0,.1);
        }

        h1 {
            text-align: center;
            color: #151515;
        }

        .aviso {
            padding: 12px;
            background: #fff3cd;
            border-radius: 8px;
            color: #664d03;
            text-align: center;
        }

        .imagem {
            display: block;
            width: 200px;
            height: 180px;
            object-fit: contain;
            margin: 20px auto;
        }

        .preco {
            font-size: 26px;
            font-weight: bold;
            color: #16803c;
        }

        label {
            display: block;
            margin: 15px 0 8px;
            font-weight: bold;
        }

        select, input[type="number"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
        }

        .resumo {
            margin-top: 25px;
            padding: 20px;
            background: #e8f3f8;
            border-radius: 10px;
        }

        .total {
            font-size: 25px;
            font-weight: bold;
            color: #087eaa;
        }

        button {
            width: 100%;
            margin-top: 25px;
            padding: 15px;
            background: #d62828;
            color: white;
            border: none;
            border-radius: 9px;
            font-size: 17px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background: #aa1f1f;
        }

        .voltar {
            display: block;
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>

<body>

<main class="container">

    <h1>Finalizar Compra</h1>

    <p class="aviso">
        Ambiente de demonstração.
        Nenhum pagamento real será realizado.
    </p>

    <?php if (!empty($produto['imagem'])): ?>
        <img
            class="imagem"
            src="assets/imagens/<?= escapar(basename($produto['imagem'])) ?>"
            alt="<?= escapar($produto['nome']) ?>"
        >
    <?php endif; ?>

    <h2><?= escapar($produto['nome']) ?></h2>

    <p><?= escapar($produto['descricao'] ?? '') ?></p>

    <p class="preco">
        R$ <?= number_format((float)$preco, 2, ',', '.') ?>
    </p>

    <form action="salvar_pedido.php" method="POST">

        <input
            type="hidden"
            name="produto_id"
            value="<?= (int)$produto['id'] ?>"
        >

        <label for="quantidade">Quantidade</label>
        <input
            type="number"
            id="quantidade"
            name="quantidade"
            value="1"
            min="1"
            max="100"
            required
        >

        <label for="forma_pagamento">
            Forma de pagamento
        </label>

        <select
            id="forma_pagamento"
            name="forma_pagamento"
            required
        >
            <option value="">Selecione</option>
            <option value="PIX">PIX - Simulação</option>
            <option value="Cartão de Crédito">
                Cartão de Crédito
            </option>
            <option value="Mercado Pago">Mercado Pago</option>
            <option value="PayPal">PayPal</option>
            <option value="Santander">Santander</option>
        </select>

        <label for="parcelas">Parcelamento</label>

        <select id="parcelas" name="parcelas" required>
            <option value="1">1 vez</option>
        </select>

        <div class="resumo">
            <h3>Resumo da compra</h3>

            <p id="texto-pagamento">
                Escolha a forma de pagamento.
            </p>

            <p>
                Valor total:
                <span class="total" id="total">R$ 0,00</span>
            </p>

            <p id="valor-parcela"></p>
        </div>

        <button type="submit">
            Confirmar Pagamento Simulado
        </button>

    </form>

    <a href="produtos.php" class="voltar">
        Voltar aos produtos
    </a>

</main>

<script>
const precoUnitario = <?= json_encode((float)$preco) ?>;

const quantidade = document.getElementById("quantidade");
const pagamento = document.getElementById("forma_pagamento");
const parcelas = document.getElementById("parcelas");

const totalElemento = document.getElementById("total");
const parcelaElemento = document.getElementById("valor-parcela");
const textoPagamento = document.getElementById("texto-pagamento");

const formato = new Intl.NumberFormat("pt-BR", {
    style: "currency",
    currency: "BRL"
});

function atualizarParcelas() {
    const forma = pagamento.value;
    let limite = 1;

    if (forma === "PIX") {
        limite = 12;
    } else if (forma === "Cartão de Crédito") {
        limite = 6;
    }

    parcelas.innerHTML = "";

    for (let i = 1; i <= limite; i++) {
        const opcao = document.createElement("option");
        opcao.value = i;
        opcao.textContent = i + (i === 1 ? " vez" : " vezes");
        parcelas.appendChild(opcao);
    }

    atualizarResumo();
}

function atualizarResumo() {
    const qtd = Number(quantidade.value);
    const total = Math.round(precoUnitario * qtd * 100) / 100;
    const numeroParcelas = Number(parcelas.value) || 1;

    if (!Number.isInteger(qtd) || qtd < 1 || qtd > 100) {
        totalElemento.textContent = "Quantidade inválida";
        parcelaElemento.textContent = "";
        return;
    }

    const valorParcela = total / numeroParcelas;

    totalElemento.textContent = formato.format(total);

    parcelaElemento.textContent =
        numeroParcelas + "x de aproximadamente " +
        formato.format(valorParcela);

    textoPagamento.textContent = pagamento.value
        ? "Pagamento selecionado: " + pagamento.value
        : "Escolha a forma de pagamento.";
}

pagamento.addEventListener("change", atualizarParcelas);
quantidade.addEventListener("input", atualizarResumo);
parcelas.addEventListener("change", atualizarResumo);

atualizarParcelas();
</script>

</body>
</html>
