<?php
/*
 * Projeto: Zeta Transporte
 * Desenvolvedor: Arthur Lázaro
 * Ano: 2026
 */

session_start();

if (!isset($_SESSION['usuario_id'])) {
    http_response_code(403);
    exit("Acesso não autorizado.");
}

require_once __DIR__ . "/config/conexao.php";

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    http_response_code(400);
    exit("Currículo inválido.");
}

$stmt = $conexao->prepare(
    "SELECT arquivo FROM curriculos WHERE id = :id"
);

$stmt->execute(['id' => $id]);

$curriculo = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$curriculo) {
    http_response_code(404);
    exit("Currículo não encontrado.");
}

$nomeArquivo = $curriculo['arquivo'];

if (
    !is_string($nomeArquivo) ||
    !preg_match('/\A[a-f0-9]{32}\.pdf\z/', $nomeArquivo)
) {
    http_response_code(400);
    exit("Arquivo inválido.");
}

$caminho = __DIR__ . "/uploads/" . $nomeArquivo;

if (!is_file($caminho)) {
    http_response_code(404);
    exit("Arquivo não encontrado.");
}

header("Content-Type: application/pdf");
header('Content-Disposition: attachment; filename="curriculo-' . $id . '.pdf"');
header("Content-Length: " . filesize($caminho));
header("X-Content-Type-Options: nosniff");

readfile($caminho);
exit;
