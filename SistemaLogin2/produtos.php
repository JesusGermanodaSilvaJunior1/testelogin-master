
<?php
/*
 * Projeto: Zeta Transporte
 * Desenvolvedor: Arthur Lázaro
 * Ano: 2026
 */

session_start();

require_once __DIR__ . "/config/conexao.php";

$sql = "SELECT * FROM produtos ORDER BY id ASC";
$stmt = $conexao->query($sql);
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

function escapar($valor) {
    return htmlspecialchars(
        (string)$valor,
        ENT_QUOTES,
        'UTF-8'
    );
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Produtos - Zeta Transporte</title>

    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        :root {
            --vermelho: #d62828;
            --vermelho-escuro: #a91d1d;
            --preto: #151515;
            --azul: #087eaa;
            --fundo: #f4f6f9;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
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
            flex-wrap: wrap;
            gap: 20px;
            align-items: center;
        }

        .cabecalho nav a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            transition: 0.2s;
        }

        .cabecalho nav a:hover {
            color: #53c6ed;
        }

        .banner-produtos {
            background: linear-gradient(
                120deg,
                var(--preto),
                var(--azul)
            );
            padding: 75px 20px;
            text-align: center;
            color: white;
        }

        .banner-produtos h1 {
            font-size: 40px;
            margin: 0 0 15px;
        }

        .banner-produtos p {
            max-width: 650px;
            margin: auto;
            font-size: 18px;
            line-height: 1.7;
        }

        .produtos-container {
            width: 100%;
            max-width: 1300px;
            margin: 0 auto;
            padding: 60px 6%;
            flex: 1;
        }

        .titulo-secao {
            text-align: center;
            margin-bottom: 35px;
        }

        .titulo-secao h2 {
            font-size: 30px;
            margin-bottom: 10px;
            color: var(--preto);
        }

        .titulo-secao p {
            color: #666;
            line-height: 1.6;
        }

        .linha-decorativa {
            width: 75px;
            height: 4px;
            background: var(--vermelho);
            margin: 18px auto 0;
            border-radius: 10px;
        }

        .grade-produtos {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 25px;
        }

        .card-produto {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.09);
            transition: transform 0.25s, box-shadow 0.25s;
            display: flex;
            flex-direction: column;
        }

        .card-produto:hover {
            transform: translateY(-6px);
            box-shadow: 0 10px 28px rgba(0,0,0,0.15);
        }

        .area-imagem {
            position: relative;
            background: #fff;
            height: 220px;
            padding: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid #eee;
        }

        .imagem-produto {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .sem-imagem {
            color: #888;
            font-size: 15px;
        }

        .etiqueta-promocao {
            position: absolute;
            top: 15px;
            left: 15px;
            background: var(--vermelho);
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: bold;
        }

        .conteudo-card {
            padding: 25px;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .conteudo-card h3 {
            font-size: 21px;
            margin: 0 0 12px;
            color: var(--preto);
        }

        .descricao {
            color: #666;
            line-height: 1.6;
            font-size: 14px;
            margin: 0 0 20px;
            flex: 1;
        }

        .preco-antigo {
            text-decoration: line-through;
            color: #888;
            font-size: 14px;
            margin: 0 0 5px;
        }

        .preco {
            color: #16803c;
            font-size: 26px;
            font-weight: bold;
            margin: 0 0 20px;
        }

        .botao-comprar {
            display: block;
            width: 100%;
            text-align: center;
            padding: 14px;
            background: var(--vermelho);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            transition: 0.2s;
        }

        .botao-comprar:hover {
            background: var(--vermelho-escuro);
        }

        .mensagem-vazia {
            grid-column: 1 / -1;
            background: white;
            border-radius: 12px;
            padding: 45px 20px;
            text-align: center;
            color: #666;
            box-shadow: 0 3px 12px rgba(0,0,0,0.08);
        }

        .informacoes {
            background: #e8f3f8;
            padding: 50px 8%;
            text-align: center;
        }

        .informacoes h2 {
            color: var(--preto);
            margin-bottom: 15px;
        }

        .informacoes p {
            max-width: 700px;
            margin: auto;
            line-height: 1.8;
            color: #444;
        }

        .rodape {
            background: var(--preto);
            color: white;
            text-align: center;
            padding: 40px 20px;
        }

        .rodape h3 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .rodape p {
            margin: 10px 0;
            line-height: 1.6;
        }

        

        @media (max-width: 900px) {
            .grade-produtos {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
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

            .banner-produtos {
                padding: 55px 20px;
            }

            .banner-produtos h1 {
                font-size: 30px;
            }

            .banner-produtos p {
                font-size: 16px;
            }

            .produtos-container {
                padding: 40px 5%;
            }

            .grade-produtos {
                grid-template-columns: 1fr;
            }

            .titulo-secao h2 {
                font-size: 26px;
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
        <a href="index.php#empresa">Empresa</a>
        <a href="index.php#servicos">Serviços</a>
        <a href="produtos.php">Produtos</a>
        <a href="curriculo.php">Trabalhe Conosco</a>

        <?php if (isset($_SESSION['usuario_id'])): ?>
            <a href="dashboard.php">Meu Painel</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="cadastro.php">Cadastrar-se</a>
        <?php endif; ?>

        <a href="#contato">Contato</a>
    </nav>

</header>

<section class="banner-produtos">

    <h1>Nossos Produtos</h1>

    <p>
        Encontre materiais de qualidade para embalagem,
        armazenamento e transporte com as melhores ofertas
        da Zeta Transporte.
    </p>

</section>

<main class="produtos-container">

    <div class="titulo-secao">

        <h2>Conheça nossos produtos</h2>

        <p>
            Confira nossas opções e aproveite
            os preços promocionais.
        </p>

        <div class="linha-decorativa"></div>

    </div>

    <div class="grade-produtos">

        <?php if (empty($produtos)): ?>

            <div class="mensagem-vazia">
                <h3>Nenhum produto disponível</h3>
                <p>
                    No momento, não existem produtos
                    cadastrados no sistema.
                </p>
            </div>

        <?php else: ?>

            <?php foreach ($produtos as $produto): ?>

                <?php
                    $tem_promocao =
                        isset($produto['preco_promocional']) &&
                        $produto['preco_promocional'] !== null &&
                        $produto['preco_promocional'] !== '';

                    $preco = $tem_promocao
                        ? $produto['preco_promocional']
                        : $produto['preco'];
                ?>

                <article class="card-produto">

                    <div class="area-imagem">

                        <?php if ($tem_promocao): ?>
                            <span class="etiqueta-promocao">
                                OFERTA
                            </span>
                        <?php endif; ?>

                        <?php if (!empty($produto['imagem'])): ?>

                            <img
                                src="assets/imagens/<?= escapar(basename($produto['imagem'])) ?>"
                                alt="<?= escapar($produto['nome']) ?>"
                                class="imagem-produto"
                            >

                        <?php else: ?>

                            <span class="sem-imagem">
                                Imagem indisponível
                            </span>

                        <?php endif; ?>

                    </div>

                    <div class="conteudo-card">

                        <h3>
                            <?= escapar($produto['nome']) ?>
                        </h3>

                        <p class="descricao">
                            <?= escapar($produto['descricao'] ?? '') ?>
                        </p>

                        <?php if ($tem_promocao): ?>

                            <p class="preco-antigo">
                                De R$
                                <?= number_format(
                                    (float)$produto['preco'],
                                    2,
                                    ',',
                                    '.'
                                ) ?>
                            </p>

                        <?php endif; ?>

                        <p class="preco">
                            R$
                            <?= number_format(
                                (float)$preco,
                                2,
                                ',',
                                '.'
                            ) ?>
                        </p>

                        <a
                            href="compra.php?id=<?= (int)$produto['id'] ?>"
                            class="botao-comprar"
                        >
                            Comprar agora
                        </a>

                    </div>

                </article>

            <?php endforeach; ?>

        <?php endif; ?>

    </div>

</main>

<section class="informacoes">

    <h2>Qualidade e segurança para suas entregas</h2>

    <p>
        A Zeta Transporte oferece produtos para
        embalagem e movimentação de mercadorias,
        ajudando a proteger seus itens durante
        o armazenamento e o transporte.
    </p>

</section>

<footer class="rodape" id="contato">

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
