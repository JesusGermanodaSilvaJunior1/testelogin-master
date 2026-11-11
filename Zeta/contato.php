<?php 
    session_start();
    include 'conexao.php';

    $mensagem = "";
    $erro = "";

    if (empty($_SESSION['csrf_cv'])) {
        $_SESSION['csrf_cv'] = bin2hex(random_bytes(16));
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome     = trim($_POST['nome'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $telefone = trim($_POST['telefone'] ?? '');
        $cargo    = trim($_POST['cargo'] ?? '');
        $lgpd     = isset($_POST['lgpd']) ? 1 : 0;
        $arquivo  = $_FILES['curriculo'] ?? null;

        if (!hash_equals($_SESSION['csrf_cv'], $_POST['csrf'] ?? '')) {
            $erro = "Sessão expirada. Atualize a página e tente novamente.";
        } elseif ($nome === '' || $cargo === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erro = "Preencha nome, e-mail e cargo corretamente.";
        } elseif (!preg_match('/^[0-9()+\-\s]{8,20}$/', $telefone)) {
            $erro = "Telefone inválido.";
        } elseif (!$lgpd) {
            $erro = "É preciso aceitar o uso dos dados para enviar o currículo.";
        } elseif (!$arquivo || $arquivo['error'] !== UPLOAD_ERR_OK) {
            $erro = "Envie o arquivo do currículo.";
        } elseif ($arquivo['size'] > 2 * 1024 * 1024) {
            $erro = "O arquivo deve ter no máximo 2 MB.";
        } else {
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $tipo = $finfo->file($arquivo['tmp_name']);
            $extensoes = [
                'application/pdf' => 'pdf',
                'application/msword' => 'doc',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx'
            ];

            if (!isset($extensoes[$tipo])) {
                $erro = "Envie o currículo em PDF, DOC ou DOCX.";
            } else {
                $nome_arquivo = bin2hex(random_bytes(16)) . "." . $extensoes[$tipo];

                if (move_uploaded_file($arquivo['tmp_name'], __DIR__ . "/uploads/" . $nome_arquivo)) {
                    $stmt = $pdo->prepare(
                        "INSERT INTO curriculos (nome, email, telefone, cargo, arquivo, consentimento_lgpd)
                         VALUES (?, ?, ?, ?, ?, ?)"
                    );
                    $stmt->execute([$nome, $email, $telefone, $cargo, $nome_arquivo, $lgpd]);
                    $mensagem = "Currículo enviado. Obrigado pelo interesse!";
                } else {
                    $erro = "Não foi possível salvar o arquivo. Tente novamente.";
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Trabalhe Conosco - Zeta Transporte</title>
</head>
<body>
    <header>
        <h1>Zeta Transporte</h1>
        <nav>
            <a href="index.php">Início</a>
            <a href="index.php#produtos">Produtos</a>
            <a href="contato.php">Trabalhe Conosco</a>
        </nav>
    </header>

    <main>
        <section class="compra">
            <h2>Trabalhe Conosco</h2>

            <?php if ($mensagem !== ""): ?>
                <p class="mensagem"><?= htmlspecialchars($mensagem) ?></p>
            <?php endif; ?>
            <?php if ($erro !== ""): ?>
                <p class="mensagem erro"><?= htmlspecialchars($erro) ?></p>
            <?php endif; ?>

            <form action="contato.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="csrf" value="<?= $_SESSION['csrf_cv'] ?>">

                <label for="nome">Nome completo</label>
                <input type="text" id="nome" name="nome" maxlength="120" required>

                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" maxlength="150" required>

                <label for="telefone">Telefone</label>
                <input type="tel" id="telefone" name="telefone" maxlength="20" required>

                <label for="cargo">Cargo desejado</label>
                <input type="text" id="cargo" name="cargo" maxlength="100" required>

                <label for="curriculo">Currículo (PDF, DOC ou DOCX, até 2 MB)</label>
                <input type="file" id="curriculo" name="curriculo" accept=".pdf,.doc,.docx" required>

                <label class="check">
                    <input type="checkbox" name="lgpd" value="1" required>
                    Autorizo a Zeta Transporte a guardar meus dados para processos seletivos, conforme a LGPD.
                </label>

                <button type="submit" class="botao">Enviar currículo</button>
            </form>
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
