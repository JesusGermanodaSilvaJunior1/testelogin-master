<?php
/*
 * Projeto: Zeta Transporte
 * Desenvolvedor: Arthur Lázaro
 * Ano: 2026
 */
require_once __DIR__ . "/config/conexao.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: curriculo.php");
    exit;
}

$nome = trim($_POST["nome"] ?? "");
$email = trim($_POST["email"] ?? "");
$telefone = trim($_POST["telefone"] ?? "");

if ($nome === "" || $email === "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: curriculo.php?erro=1");
    exit;
}

if (
    !isset($_FILES["curriculo"]) ||
    $_FILES["curriculo"]["error"] !== UPLOAD_ERR_OK
) {
    header("Location: curriculo.php?erro=1");
    exit;
}

$arquivo = $_FILES["curriculo"];

if ($arquivo["size"] > 5 * 1024 * 1024) {
    header("Location: curriculo.php?erro=1");
    exit;
}

$extensao = strtolower(pathinfo($arquivo["name"], PATHINFO_EXTENSION));

$finfo = new finfo(FILEINFO_MIME_TYPE);
$tipo = $finfo->file($arquivo["tmp_name"]);

if ($extensao !== "pdf" || $tipo !== "application/pdf") {
    header("Location: curriculo.php?erro=1");
    exit;
}

$pasta = __DIR__ . "/uploads/";

if (!is_dir($pasta)) {
    mkdir($pasta, 0755, true);
}

$nomeArquivo = bin2hex(random_bytes(16)) . ".pdf";
$caminho = $pasta . $nomeArquivo;

if (!move_uploaded_file($arquivo["tmp_name"], $caminho)) {
    header("Location: curriculo.php?erro=1");
    exit;
}

try {
    $sql = "INSERT INTO curriculos (nome, email, telefone, arquivo)
            VALUES (:nome, :email, :telefone, :arquivo)";

    $stmt = $conexao->prepare($sql);

    $stmt->execute([
        "nome" => $nome,
        "email" => $email,
        "telefone" => $telefone !== "" ? $telefone : null,
        "arquivo" => $nomeArquivo
    ]);

    header("Location: curriculo.php?sucesso=1");
    exit;

} catch (PDOException $e) {
    if (file_exists($caminho)) {
        unlink($caminho);
    }

    error_log($e->getMessage());

    header("Location: curriculo.php?erro=1");
    exit;
}
