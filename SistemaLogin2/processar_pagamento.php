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
    header("Location: meus_pedidos.php");
    exit;
}

$pedido_id = filter_input(
    INPUT_POST,
    'pedido_id',
    FILTER_VALIDATE_INT
);

$csrf = $_POST['csrf'] ?? '';

if (
    !$pedido_id ||
    !is_string($csrf) ||
    empty($_SESSION['csrf_pagamento']) ||
    !hash_equals($_SESSION['csrf_pagamento'], $csrf)
) {
    http_response_code(403);
    die("Solicitação inválida.");
}

$stmt = $conexao->prepare(
    "UPDATE pedidos
     SET status = 'Pago (Simulado)'
     WHERE id = ?
       AND usuario_id = ?
       AND status = 'Pendente'"
);

$stmt->execute([
    $pedido_id,
    $_SESSION['usuario_id']
]);

if ($stmt->rowCount() !== 1) {
    http_response_code(400);
    die("Pedido não encontrado ou já processado.");
}

unset($_SESSION['csrf_pagamento']);

header(
    "Location: pedido_sucesso.php?id=" .
    urlencode($pedido_id)
);
exit;
