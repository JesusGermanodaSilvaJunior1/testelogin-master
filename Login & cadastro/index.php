<?php
    session_start();
    include 'conexao.php';
 
    if(isset($_SESSION['logado'])){
        header("Location: dashboard.php");
        exit;
    }
 
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn'])){
        $nome = trim($_POST['nome']);
        $email = trim($_POST['email']);
        $senha = $_POST['senha'];
 
        $sql = "SELECT * FROM `clientes` WHERE nome = ? AND email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $nome, $email);
        mysqli_stmt_execute($stmt);
 
        $result = mysqli_stmt_get_result($stmt);
        $usuario = mysqli_fetch_assoc($result);
 
        if($usuario && password_verify($senha, $usuario['senha'])){
            session_regenerate_id(true);
            $_SESSION['logado'] = true;
            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['email'] = $usuario['email'];
 
            header("Location: dashboard.php");
            exit;
        } else {
            $_SESSION['erro'] = "Dados inválidos. Por favor, tente novamente.";
            header("Location: index.php");
            exit;
        }
    }
 
    $erro = "";
    if(isset($_SESSION['erro'])){
        $erro = $_SESSION['erro'];
        unset($_SESSION['erro']);
    }
?>
 
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Vitor Alves Vieira Santos">
    <link rel="stylesheet" href="style.css">
    <title>loja</title>
</head>
<body>
    <form action="index.php" method="post">
        <h2>Login</h2>
        <?php if($erro != ""){ ?>
            <p><?php echo htmlspecialchars($erro); ?></p>
        <?php } ?>
        <input type="text" name="nome" id="" placeholder="Insira seu nome"><br>
        <input type="email" name="email" id="" placeholder="Insira seu email"><br>
        <input type="password" name="senha" id="" placeholder="Insira sua senha"><br>
        <input type="submit" name="btn" value="Logar">
        <center><p class="possui_conta">não possui conta? </p><a href="cadastro.php" class="alternativa">Cadastre-se</a></center>
    </form>
</body>
</html>