<?php 
    session_start();
    include 'conexao.php';

    $produtos = $pdo->query("SELECT * FROM produtos WHERE ativo = 1 ORDER BY id LIMIT 6")->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Vior Alves Vieira Santos">
    <link rel="stylesheet" href="style.css">
    <title>Zeta Transporte - Logística</title>
</head>
<body>
    <header>
        <h1>Zeta Transporte</h1>
        <nav>
            <a href="index.php">Início</a>
            <a href="#produtos">Produtos</a>
            <a href="contato.php">Trabalhe Conosco</a>
        </nav>
    </header>

    <main>
        <section id="produtos">
            <h2>Produtos</h2>
            <div class="grade">
                <?php foreach ($produtos as $produto): ?>
                    <article class="card">
                        <img src="img/<?= htmlspecialchars($produto['imagem']) ?>" alt="<?= htmlspecialchars($produto['nome']) ?>">
                        <h3><?= htmlspecialchars($produto['nome']) ?></h3>
                        <p class="descricao"><?= htmlspecialchars($produto['descricao']) ?></p>

                        <?php if ($produto['preco_promocional'] !== null): ?>
                            <p class="preco-antigo">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></p>
                            <p class="preco">R$ <?= number_format($produto['preco_promocional'], 2, ',', '.') ?></p>
                        <?php else: ?>
                            <p class="preco">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></p>
                        <?php endif; ?>

                        <a class="botao" href="compra.php?id=<?= (int) $produto['id'] ?>">Comprar</a>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <footer>
        <p>
            Av. dos Gansos Pretos, 10040 – Bairro Nova Esperança – Belém/PA – Brasil<br>
            Telefone: (31) 3201-1527<br>
            CNPJ: 45.345.496/0001-05
        </p>
    </footer>
</body>
</html>
