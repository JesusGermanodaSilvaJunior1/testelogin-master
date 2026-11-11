<?php
/*
 * Projeto: Zeta Transporte
 * Desenvolvedor: Arthur Lázaro
 * Ano: 2026
 */
require_once __DIR__ . "/config/conexao.php";

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($username === "" || $password === "") {
        $mensagem = "Preencha todos os campos.";
    } elseif (strlen($password) < 6) {
        $mensagem = "A senha precisa ter pelo menos 6 caracteres.";
    } else {

        $verificar = $conexao->prepare(
            "SELECT id FROM usuarios WHERE username = ?"
        );
        $verificar->execute([$username]);

        if ($verificar->fetch()) {
            $mensagem = "Esse usuário já está cadastrado.";
        } else {

            $senhaHash = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO usuarios (username, password_hash)
                    VALUES (?, ?)";

            $stmt = $conexao->prepare($sql);
            $stmt->execute([$username, $senhaHash]);

            header("Location: login.php?cadastro=sucesso");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name"author" content="Arthur Lazaro">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Usuário - Zeta Transporte</title>

    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        .cadastro-container {
            max-width: 420px;
            margin: 70px auto;
            padding: 30px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.12);
        }

        .cadastro-container h1 {
            text-align: center;
            margin-bottom: 25px;
        }

        .cadastro-container input {
            width: 100%;
            padding: 13px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 7px;
            box-sizing: border-box;
        }

        .cadastro-container button {
            width: 100%;
            padding: 13px;
            margin-top: 15px;
            background: #e63946;
            color: white;
            border: none;
            border-radius: 7px;
            font-weight: bold;
            cursor: pointer;
        }

        .mensagem {
            color: #e63946;
            text-align: center;
        }
    </style>
</head>

<body>

<div class="cadastro-container">

    <h1>Criar primeira conta</h1>

    <?php if ($mensagem !== ""): ?>
        <p class="mensagem">
            <?= htmlspecialchars($mensagem) ?>
        </p>
    <?php endif; ?>

    <form method="POST">

        <label>Nome de usuário</label>
        <input type="text" name="username" required>

        <label>Senha</label>
        <input type="password" name="password" minlength="6" required>

        <button type="submit">Cadastrar usuário</button>

    </form>

</div>

</body>
</html>
