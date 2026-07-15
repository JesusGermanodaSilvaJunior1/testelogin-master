<?php
$conexao = mysqli_connect("localhost", "root", "", "projeto_aclama1");
$msg = "";
$erro = "";

if (isset($_POST['cadastrar'])) {
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    $verificar = "SELECT * FROM usuarios WHERE username = '$usuario'";
    $resultado = mysqli_query($conexao, $verificar);

    if (mysqli_num_rows($resultado) > 0) {
        $erro = "Este usuário já existe! Escolha outro.";
    } else {
        $sql = "INSERT INTO usuarios (username, password) VALUES ('$usuario', '$senha')";
        if (mysqli_query($conexao, $sql)) {
            $msg = "Usuário cadastrado com sucesso!";
        } else {
            $erro = "Erro ao cadastrar usuário.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Maria Eduarda Araújo dos Santos Teixeira">
    <title>Criar Conta</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="login-box">
    <h2>Criar Nova Conta</h2>
    
    <?php if ($erro != "") { ?>
        <div class="error-msg"><?php echo $erro; ?></div>
    <?php } ?>

    <?php if ($msg != "") { ?>
        <div class="success-msg"><?php echo $msg; ?></div>
    <?php } ?>

    <form action="cadastro.php" method="POST">
        <div class="input-group">
            <label>Usuário</label>
            <input type="text" name="usuario" required>
        </div>
        <div class="input-group">
            <label>Senha</label>
            <input type="password" name="senha" required>
        </div>
        <button type="submit" name="cadastrar">Cadastrar</button>
    </form>

    <p>
        Já tem uma conta? <a href="login.php">Entrar aqui</a>
    </p>
</div>

</body>
</html>