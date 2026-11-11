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

$erro = $_GET['erro'] ?? '';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Criar Conta - Zeta Transporte</title>

    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        :root {
            --vermelho: #d62828;
            --preto: #151515;
            --azul: #087eaa;
            --fundo: #f4f6f9;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--fundo);
            font-family: Arial, sans-serif;
            color: #222;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .cabecalho {
            background: var(--preto);
            padding: 20px 7%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
        }

        .cabecalho .logo {
            color: white;
            font-size: 25px;
            font-weight: bold;
        }

        .cabecalho .logo span {
            color: var(--vermelho);
        }

        .cabecalho nav {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .cabecalho nav a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .cabecalho nav a:hover {
            color: #53c6ed;
        }

        .area-cadastro {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 50px 20px;
        }

        .cadastro-container {
            width: 100%;
            max-width: 480px;
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.1);
            border-top: 5px solid var(--vermelho);
        }

        .icone-cadastro {
            width: 65px;
            height: 65px;
            margin: 0 auto 20px;
            background: #e8f3f8;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 30px;
        }

        .cadastro-container h1 {
            text-align: center;
            color: var(--preto);
            margin-bottom: 10px;
            font-size: 28px;
        }

        .subtitulo {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .campo {
            margin-bottom: 20px;
        }

        .campo label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        .campo input {
            display: block;
            width: 100%;
            padding: 14px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
            background: #fafafa;
            transition: 0.2s;
        }

        .campo input:focus {
            outline: none;
            border-color: var(--azul);
            box-shadow: 0 0 0 3px rgba(8,126,170,0.12);
            background: white;
        }

        .dica-senha {
            color: #777;
            font-size: 12px;
            margin-top: 7px;
        }

        .btn-cadastrar {
            display: block;
            width: 100%;
            padding: 15px;
            margin-top: 25px;
            border: none;
            border-radius: 8px;
            background: var(--vermelho);
            color: white;
            font-size: 17px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-cadastrar:hover {
            background: #a91d1d;
            transform: translateY(-2px);
        }

        .erro {
            background: #ffe3e3;
            color: #a11b1b;
            padding: 13px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .separador {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 25px 0;
            color: #888;
        }

        .separador::before,
        .separador::after {
            content: "";
            flex: 1;
            height: 1px;
            background: #ddd;
        }

        .login-area {
            text-align: center;
        }

        .login-area p {
            color: #555;
            margin-bottom: 15px;
        }

        .btn-login {
            display: block;
            width: 100%;
            padding: 13px;
            background: var(--azul);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: 0.2s;
        }

        .btn-login:hover {
            background: #066286;
        }

        .voltar {
            display: block;
            text-align: center;
            margin-top: 25px;
            color: var(--azul);
            text-decoration: none;
        }

        .rodape {
            background: var(--preto);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }

        .rodape p {
            margin: 8px 0;
            line-height: 1.5;
        }

        @media (max-width: 600px) {
            .cabecalho {
                justify-content: center;
                text-align: center;
            }

            .cabecalho nav {
                justify-content: center;
                gap: 15px;
            }

            .area-cadastro {
                padding: 30px 15px;
            }

            .cadastro-container {
                padding: 25px;
            }

            .cadastro-container h1 {
                font-size: 25px;
            }
        }
    </style>
</head>

<body>

<header class="cabecalho">

    <div class="logo">
        ZETA <span>TRANSPORTE</span>
    </div>

    <nav>
        <a href="index.php">Início</a>
        <a href="produtos.php">Produtos</a>
        <a href="curriculo.php">Trabalhe Conosco</a>
        <a href="login.php">Login</a>
        <a href="cadastro.php">Cadastre-se</a>
    </nav>

</header>

<main class="area-cadastro">

    <div class="cadastro-container">

        <div></div>

        <h1>Criar sua conta</h1>

        <p class="subtitulo">
            Cadastre-se na Zeta Transporte para
            realizar compras e acompanhar seus pedidos.
        </p>

        <?php if ($erro === 'usuario'): ?>

            <div class="erro">
                Este nome de usuário já está cadastrado.
            </div>

        <?php elseif ($erro === 'senha'): ?>

            <div class="erro">
                As senhas não coincidem.
            </div>

        <?php elseif ($erro === 'dados'): ?>

            <div class="erro">
                Verifique os dados informados.
            </div>

        <?php elseif ($erro === 'servidor'): ?>

            <div class="erro">
                Não foi possível cadastrar.
                Tente novamente.
            </div>

        <?php endif; ?>

        <form action="salvar_usuario.php" method="POST">

            <div class="campo">

                <label for="username">
                    Nome de usuário
                </label>

                <input
                    type="text"
                    id="username"
                    name="username"
                    placeholder="Digite seu nome de usuário"
                    minlength="3"
                    maxlength="100"
                    autocomplete="username"
                    required
                >

            </div>

            <div class="campo">

                <label for="password">
                    Senha
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Crie uma senha"
                    minlength="8"
                    maxlength="72"
                    autocomplete="new-password"
                    required
                >

                <p class="dica-senha">
                    A senha deve ter pelo menos 8 caracteres.
                </p>

            </div>

            <div class="campo">

                <label for="confirmar_senha">
                    Confirmar senha
                </label>

                <input
                    type="password"
                    id="confirmar_senha"
                    name="confirmar_senha"
                    placeholder="Digite a senha novamente"
                    minlength="8"
                    maxlength="72"
                    autocomplete="new-password"
                    required
                >

            </div>

            <button type="submit" class="btn-cadastrar">
                Criar minha conta
            </button>

        </form>

        <div class="separador">OU</div>

        <div class="login-area">

            <p>Já possui uma conta?</p>

            <a href="login.php" class="btn-login">
                Entrar na minha conta
            </a>

        </div>

        <a href="index.php" class="voltar">
            Voltar ao início
        </a>

    </div>

</main>

<footer class="rodape">

    <h3>Zeta Transporte</h3>

    <p>
        Avenida dos Gansos Pretos, 10040 -
        Nova Esperança - Belém - Pará - Brasil
    </p>

    <p>Telefone: (31) 3201-1527</p>

    <p>CNPJ: 45.345.496/0001-05</p>

    <p>
        Zeta Transporte - Todos os direitos reservados.
    </p>
    
    <p>Desenvolvido por Arthur Lázaro</p>

    

</footer>

</body>
</html>
