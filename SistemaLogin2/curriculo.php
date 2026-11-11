<?php
/*
 * Projeto: Zeta Transporte
 * Desenvolvedor: Arthur Lázaro
 * Ano: 2026
 */
$mensagem = "";

if (isset($_GET['sucesso'])) {
    $mensagem = "Currículo enviado com sucesso!";
}

if (isset($_GET['erro'])) {
    $mensagem = "Erro ao enviar currículo. Confira os dados e tente novamente.";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Envie seu Currículo - Zeta Transporte</title>
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        .curriculo-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.10);
        }

        .curriculo-container h1 {
            text-align: center;
            margin-bottom: 15px;
        }

        .curriculo-container p {
            text-align: center;
            margin-bottom: 25px;
        }

        .curriculo-container label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        .curriculo-container input {
            width: 100%;
            padding: 13px;
            margin-top: 7px;
            border: 1px solid #ccc;
            border-radius: 7px;
            box-sizing: border-box;
        }

        .curriculo-container button {
            width: 100%;
            padding: 15px;
            margin-top: 25px;
            background: #e63946;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
        }

        .mensagem {
            color: #16803c;
            font-weight: bold;
        }
    </style>
</head>

<body>

<header>
    <div class="logo">ZETA <span>TRANSPORTE</span></div>
    <nav>
        <a href="index.php">Início</a>
        <a href="produtos.php">Produtos</a>
        <a href="login.php">Login</a>
    </nav>
</header>

<main class="curriculo-container">

    <h1>Trabalhe Conosco</h1>

    <p>Faça parte da equipe Zeta Transporte! Envie seu currículo.</p>

    <?php if ($mensagem !== ""): ?>
        <p class="mensagem">
            <?= htmlspecialchars($mensagem) ?>
        </p>
    <?php endif; ?>

    <form action="salvar_curriculo.php" method="POST" enctype="multipart/form-data">

        <label>Nome completo</label>
        <input type="text" name="nome" maxlength="150" required>

        <label>E-mail</label>
        <input type="email" name="email" maxlength="150" required>

        <label>Telefone</label>
        <input type="tel" name="telefone" maxlength="30">

        <label>Currículo (PDF)</label>
        <input type="file" name="curriculo" accept=".pdf,application/pdf" required>

        <button type="submit">Enviar Currículo</button>

    </form>

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
