<?php
session_start();
require "conexao.php";

$erro = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $usuario_digitado = trim($_POST['usuario'] ?? '');
    $senha_digitada = $_POST['senha'] ?? '';

    if ($usuario_digitado === '' || $senha_digitada === '') {
        $erro = "Preencha usuário e senha.";
    } else {
        $stmt = mysqli_prepare($conexao, "SELECT id, username, password FROM usuarios WHERE username = ?");
        mysqli_stmt_bind_param($stmt, "s", $usuario_digitado);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        $usuarioEncontrado = mysqli_fetch_assoc($resultado);

        if ($usuarioEncontrado && password_verify($senha_digitada, $usuarioEncontrado['password'])) {
            $_SESSION['usuario_id'] = $usuarioEncontrado['id'];
            $_SESSION['usuario_nome'] = $usuarioEncontrado['username'];
            header("Location: dashboard.php");
            exit();
        } else {
            $erro = "Usuário ou senha inválidos.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
    </style>
</head>

<body>

    <div class="login-container">
        <h1 class="text-center mb-4">Login</h1>

        <?php if (!empty($erro)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuário</label>
                <input type="text" name="usuario" id="usuario" class="form-control" placeholder="Digite seu usuário" required>
            </div>

            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" name="senha" id="senha" class="form-control" placeholder="Digite sua senha" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Entrar</button>
        </form>
    </div>

</body>

</html>