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

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: produtos.php");
    exit;
}

$usuario_id = (int)$_SESSION['usuario_id'];

$produto_id = filter_input(
    INPUT_POST,
    'produto_id',
    FILTER_VALIDATE_INT
);

$quantidade = filter_input(
    INPUT_POST,
    'quantidade',
    FILTER_VALIDATE_INT
);

$parcelas = filter_input(
    INPUT_POST,
    'parcelas',
    FILTER_VALIDATE_INT
);

$forma_pagamento = $_POST['forma_pagamento'] ?? '';

$limites = [
    'PIX' => 12,
    'Cartão de Crédito' => 6,
    'Mercado Pago' => 1,
    'PayPal' => 1,
    'Santander' => 1
];

if (
    !$produto_id ||
    !$quantidade ||
    $quantidade < 1 ||
    $quantidade > 100 ||
    !is_string($forma_pagamento) ||
    !isset($limites[$forma_pagamento]) ||
    !$parcelas ||
    $parcelas < 1 ||
    $parcelas > $limites[$forma_pagamento]
) {
    die("Dados de compra inválidos.");
}

try {
    $conexao->beginTransaction();

    $stmt = $conexao->prepare(
        "SELECT * FROM produtos WHERE id = ?"
    );

    $stmt->execute([$produto_id]);

    $produto = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$produto) {
        throw new Exception("Produto não encontrado.");
    }

    $preco = (
        isset($produto['preco_promocional']) &&
        $produto['preco_promocional'] !== null &&
        $produto['preco_promocional'] !== ''
    )
        ? $produto['preco_promocional']
        : $produto['preco'];

    $preco_unitario = round((float)$preco, 2);

    if ($preco_unitario < 0) {
        throw new Exception("Preço inválido.");
    }

    $valor_total = round(
        $preco_unitario * $quantidade,
        2
    );

    $valor_parcela = round(
        $valor_total / $parcelas,
        2
    );

    $stmt = $conexao->prepare(
        "INSERT INTO pedidos
        (
            usuario_id,
            valor_total,
            forma_pagamento,
            status,
            parcelas,
            valor_parcela
        )
        VALUES (?, ?, ?, ?, ?, ?)"
    );

    $stmt->execute([
        $usuario_id,
        $valor_total,
        $forma_pagamento,
        'Pendente',
        $parcelas,
        $valor_parcela
    ]);

    $pedido_id = $conexao->lastInsertId();

    $stmt = $conexao->prepare(
        "INSERT INTO itens_pedido
        (
            pedido_id,
            produto_id,
            quantidade,
            preco_unitario
        )
        VALUES (?, ?, ?, ?)"
    );

    $stmt->execute([
        $pedido_id,
        $produto_id,
        $quantidade,
        $preco_unitario
    ]);

    $conexao->commit();

    header(
        "Location: confirmar_pagamento.php?id=" .
        urlencode($pedido_id)
    );
    exit;

} catch (Throwable $erro) {

    if ($conexao->inTransaction()) {
        $conexao->rollBack();
    }

    error_log($erro->getMessage());

    http_response_code(500);
    die("Erro ao registrar o pedido.");
}
