<?php
/*
 * Projeto: Zeta Transporte
 * Desenvolvedor: Arthur Lázaro
 * Ano: 2026
 */
session_start();

require_once __DIR__ . "/config/conexao.php";

$stmt = $conexao->query(
    "SELECT * FROM produtos ORDER BY id ASC LIMIT 6"
);

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
    <meta name"author" content="Arthur Lazaro">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Zeta Transporte | Logística e Transporte</title>

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
            font-family: Arial, sans-serif;
            background: var(--fundo);
            color: #222;
        }

        .cabecalho {
            background: var(--preto);
            padding: 20px 7%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .logo {
            color: white;
            font-size: 25px;
            font-weight: bold;
        }

        .logo span {
            color: var(--vermelho);
        }

        .cabecalho nav {
            display: flex;
            flex-wrap: wrap;
            gap: 18px;
        }

        .cabecalho nav a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .cabecalho nav a:hover {
            color: #53c6ed;
        }

        .banner {
            background: linear-gradient(
                120deg,
                #151515,
                #087eaa
            );

            color: white;
            text-align: center;
            padding: 100px 20px;
        }

        .banner h1 {
            font-size: 42px;
            margin-bottom: 20px;
        }

        .banner p {
            font-size: 19px;
            max-width: 650px;
            margin: 0 auto 30px;
            line-height: 1.6;
        }

        .botao {
            display: inline-block;
            padding: 13px 25px;
            background: var(--vermelho);
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.2s;
        }

        .botao:hover {
            background: #a91d1d;
            transform: translateY(-2px);
        }

        .secao {
            padding: 65px 8%;
            text-align: center;
        }

        .secao h2 {
            font-size: 30px;
            margin-bottom: 20px;
            color: var(--preto);
        }

        .secao > p {
            max-width: 800px;
            margin: 0 auto 30px;
            line-height: 1.8;
        }

        .servicos {
            display: grid;
            grid-template-columns: repeat(
                auto-fit,
                minmax(220px, 1fr)
            );
            gap: 20px;
            margin-top: 35px;
        }

        .servico {
            background: white;
            padding: 30px;
            border-radius: 12px;
            border-top: 5px solid var(--azul);
            box-shadow: 0 3px 12px rgba(0,0,0,0.08);
        }

        .servico h3 {
            color: var(--vermelho);
        }

        .grade-produtos {
            display: grid;
            grid-template-columns: repeat(
                3,
                minmax(0, 1fr)
            );
            gap: 25px;
            margin-top: 35px;
        }

        .card-produto {
            background: white;
            border-radius: 14px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.09);
            transition: 0.2s;
        }

        .card-produto:hover {
            transform: translateY(-5px);
        }

        .card-produto img {
            width: 100%;
            height: 170px;
            object-fit: contain;
            margin-bottom: 15px;
        }

        .card-produto h3 {
            font-size: 20px;
        }

        .preco-antigo {
            color: #777;
            text-decoration: line-through;
        }

        .preco {
            color: #16803c;
            font-size: 24px;
            font-weight: bold;
            margin: 12px 0 20px;
        }

        .curriculos {
            background: #e8f3f8;
        }

        .rodape {
            background: var(--preto);
            color: white;
            padding: 45px 8%;
            text-align: center;
        }

        .rodape p {
            margin: 10px 0;
            line-height: 1.6;
        }

        @media (max-width: 800px) {
            .grade-produtos {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 550px) {
            .grade-produtos {
                grid-template-columns: 1fr;
            }

            .banner h1 {
                font-size: 30px;
            }

            .cabecalho {
                justify-content: center;
                text-align: center;
            }

            .cabecalho nav {
                justify-content: center;
            }

            .secao {
                padding: 45px 5%;
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
        <a href="#empresa">Empresa</a>
        <a href="#servicos">Serviços</a>
        <a href="#produtos">Produtos</a>
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

<section class="banner">

    <h1>Bem-vindo à Zeta Transporte</h1>

    <p>
        Soluções em transporte e logística
        com eficiência, segurança e compromisso
        com nossos clientes.
    </p>

    <a href="#produtos" class="botao">
        Conheça nossos produtos
    </a>

</section>

<section class="secao" id="empresa">

    <h2>Sobre Nossa Empresa</h2>

    <p>
        A Zeta Transporte é uma empresa que presta
        serviços de logística, oferecendo soluções
        para atender às necessidades de seus clientes.

        Nosso objetivo é proporcionar qualidade,
        organização, segurança e eficiência
        nos serviços prestados.
    </p>

</section>

<section class="secao" id="servicos">

    <h2>Nossos Serviços</h2>

    <div class="servicos">

        <div class="servico">
            <h3>Transporte</h3>
            <p>
                Soluções de transporte para
                atender às necessidades logísticas.
            </p>
        </div>

        <div class="servico">
            <h3>Logística</h3>
            <p>
                Organização e planejamento
                de processos logísticos.
            </p>
        </div>

        <div class="servico">
            <h3>Produtos</h3>
            <p>
                Materiais e acessórios para
                embalagem e transporte.
            </p>
        </div>

        <div class="servico">
            <h3>Atendimento</h3>
            <p>
                Compromisso com a qualidade
                e satisfação dos clientes.
            </p>
        </div>

    </div>

</section>

<section class="secao" id="produtos">

    <h2>Nossos Produtos</h2>

    <p>
        Conheça os produtos disponíveis
        para compra na Zeta Transporte.
    </p>

    <div class="grade-produtos">

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

            <div class="card-produto">

                <?php if (!empty($produto['imagem'])): ?>

                    <img
                        src="assets/imagens/<?= escapar(basename($produto['imagem'])) ?>"
                        alt="<?= escapar($produto['nome']) ?>"
                    >

                <?php endif; ?>

                <h3>
                    <?= escapar($produto['nome']) ?>
                </h3>

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
                    class="botao"
                    href="compra.php?id=<?= (int)$produto['id'] ?>"
                >
                    Comprar
                </a>

            </div>

        <?php endforeach; ?>

    </div>

</section>

<section class="secao curriculos" id="curriculos">

    <h2>Trabalhe Conosco</h2>

    <p>
        Tem interesse em fazer parte da
        equipe Zeta Transporte?

        Envie seu currículo em PDF
        através do nosso formulário.
    </p>

    <a href="curriculo.php" class="botao">
        Enviar Currículo
    </a>

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
