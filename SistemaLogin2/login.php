<?php
/*
 * Projeto: Zeta Transporte
 * Desenvolvedor: Arthur Lázaro
 * Ano: 2026
 */
session_start();

if (isset($_SESSION['usuario_id'])) {
    header("Location: dashboard.php");
    exit;
}

$mensagem = "";
$sucesso = false;

if (isset($_GET['cadastro']) && $_GET['cadastro'] === 'sucesso') {
    $mensagem = "Usuário cadastrado com sucesso! Faça seu login.";
    $sucesso = true;
}

if (isset($_GET['erro'])) {
    $mensagem = "Usuário ou senha incorretos.";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - Zeta Transporte</title>

    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #f4f6f9;
            font-family: Arial, sans-serif;
        }

        .login-container {
            max-width: 420px;
            margin: 70px auto;
            padding: 35px;
            background: white;
            border-radius: 14px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.12);
        }

        .login-container h1 {
            text-align: center;
            margin-bottom: 10px;
            color: #151515;
        }

        .subtitulo {
            text-align: center;
            color: #666;
            margin-bottom: 25px;
        }

        .login-container label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .login-container input {
            width: 100%;
            padding: 13px;
            margin: 8px 0 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        .login-container input:focus {
            outline: 2px solid #087eaa;
        }

        .btn-entrar {
            width: 100%;
            padding: 14px;
            background: #d62828;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn-entrar:hover {
            background: #a91d1d;
        }

        .mensagem {
            text-align: center;
            color: #d62828;
            margin-bottom: 15px;
            padding: 12px;
            background: #ffe3e3;
            border-radius: 8px;
        }

        .mensagem.sucesso {
            color: #16803c;
            background: #e0f5e7;
        }

        .separador {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 25px 0;
            color: #777;
        }

        .separador::before,
        .separador::after {
            content: "";
            flex: 1;
            height: 1px;
            background: #ddd;
        }

        .cadastro-area {
            text-align: center;
        }

        .cadastro-area p {
            color: #555;
            margin-bottom: 15px;
        }

        .btn-cadastro {
            display: block;
            width: 100%;
            padding: 13px;
            background: #087eaa;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            text-align: center;
        }

        .btn-cadastro:hover {
            background: #066286;
        }

        .voltar {
            display: block;
            text-align: center;
            margin-top: 25px;
            color: #087eaa;
            text-decoration: none;
        }

        @media (max-width: 500px) {
            .login-container {
                margin: 30px 15px;
                padding: 25px;
            }
        }
    </style>
</head>

<body>

<header>
    <div class="logo">
        ZETA <span>TRANSPORTE</span>
    </div>

    <nav>
        <a href="index.php">Início</a>
        <a href="produtos.php">Produtos</a>
        <a href="login.php">Login</a>
        <a href="cadastro.php">Cadastre-se</a>
    </nav>
</header>

<main class="login-container">

    <h1>Área de Login</h1>

    <p class="subtitulo">
        Entre na sua conta para continuar.
    </p>

    <?php if ($mensagem !== ""): ?>

        <p class="mensagem <?= $sucesso ? 'sucesso' : '' ?>">
            <?= htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8') ?>
        </p>

    <?php endif; ?>

    <form action="autenticar.php" method="POST">

        <label for="username">Nome de usuário</label>

        <input
            type="text"
            id="username"
            name="username"
            placeholder="Digite seu usuário"
            autocomplete="username"
            required
        >

        <label for="password">Senha</label>

        <input
            type="password"
            id="password"
            name="password"
            placeholder="Digite sua senha"
            autocomplete="current-password"
            required
        >

        <button type="submit" class="btn-entrar">
            Entrar
        </button>

    </form>

    <div class="separador">OU</div>

    <div class="cadastro-area">

        <p>Ainda não possui uma conta?</p>

        <a href="cadastro.php" class="btn-cadastro">
            Criar uma conta
        </a>

    </div>

    <a href="index.php" class="voltar">
        Voltar ao início
    </a>

</main>

<footer>
    <h3>Zeta Transporte</h3>

    <p>
        Avenida dos Gansos Pretos, 10040 -
        Nova Esperança - Belém - Pará - Brasil
    </p>

    <p>Telefone: (31) 3201-1527</p>

    <p>CNPJ: 45.345.496/0001-05</p>

    <p>
        © 2026 Zeta Transporte -
        Todos os direitos reservados.
    </p>

    <p>
        Desenvolvido por Arthur Lázaro
    </p>
</footer>

</body>
</html>
