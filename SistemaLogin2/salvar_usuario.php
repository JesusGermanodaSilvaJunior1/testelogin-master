<?php
/*
 * Projeto: Zeta Transporte
 * Desenvolvedor: Arthur Lázaro
 * Ano: 2026
 */
require_once __DIR__ . "/config/conexao.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: cadastro.php");
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$confirmar = $_POST['confirmar_senha'] ?? '';

if (
    !is_string($username) ||
    !is_string($password) ||
    !is_string($confirmar) ||
    mb_strlen($username) < 3 ||
    mb_strlen($username) > 100 ||
    strlen($password) < 8 ||
    strlen($password) > 72
) {
    header("Location: cadastro.php?erro=dados");
    exit;
}

if ($password !== $confirmar) {
    header("Location: cadastro.php?erro=senha");
    exit;
}

try {
    $stmt = $conexao->prepare(
        "SELECT id FROM usuarios WHERE username = ?"
    );
    $stmt->execute([$username]);

    if ($stmt->fetch()) {
        header("Location: cadastro.php?erro=usuario");
        exit;
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conexao->prepare(
        "INSERT INTO usuarios (username, password_hash)
         VALUES (?, ?)"
    );

    $stmt->execute([$username, $hash]);

    header("Location: login.php?cadastro=sucesso");
    exit;

} catch (PDOException $erro) {
    error_log($erro->getMessage());

    header("Location: cadastro.php?erro=servidor");
    exit;
}
