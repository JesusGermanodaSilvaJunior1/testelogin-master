
<?php

/*
 * Projeto: Zeta Transporte
 * Desenvolvedor: Arthur Lázaro
 * Ano: 2026
 */

session_start();

require_once __DIR__ . "/config/conexao.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: login.php");
    exit;
}

$username = trim($_POST["username"] ?? "");
$password = $_POST["password"] ?? "";

if ($username === "" || $password === "") {
    header("Location: login.php?erro=1");
    exit;
}

$sql = "SELECT id, username, password_hash
        FROM usuarios
        WHERE username = :username";

$stmt = $conexao->prepare($sql);
$stmt->execute(['username' => $username]);

$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if ($usuario && password_verify($password, $usuario['password_hash'])) {

    session_regenerate_id(true);

    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['usuario'] = $usuario['username'];

    header("Location: dashboard.php");
    exit;
}

header("Location: login.php?erro=1");
exit;
