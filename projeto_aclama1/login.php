<?php
session_start();

$conexao = mysqli_connect("localhost", "root", "", "projeto_aclama1");

$erro = "";

if (isset($_POST['entrar'])) {
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE username = '$usuario' AND password = '$senha'";
    $resultado = mysqli_query($conexao, $sql);

    if (mysqli_num_rows($resultado) > 0) {
        $_SESSION['usuario'] = $usuario;
        header("Location: dashboard.php");
        exit;
    } else {
        $erro = "Usuário ou senha errados!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Maria Eduarda Araújo dos Santos Teixeira">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="login-box">
    <h2>Entrar no Sistema</h2>
    
    <?php if ($erro != "") { ?>
        <div class="error-msg"><?php echo $erro; ?></div>
    <?php } ?>

    <form action="login.php" method="POST">
        <div class="input-group">
            <label>Usuário</label>
            <input type="text" name="usuario" required>
        </div>
        <div class="input-group">
            <label>Senha</label>
            <input type="password" name="senha" required>
        </div>
        <button type="submit" name="entrar">Logar</button>
    </form>

    <p>
        Não tem uma conta? <a href="cadastro.php">Cadastre-se</a>
    </p>
</div>

</body>
</html>