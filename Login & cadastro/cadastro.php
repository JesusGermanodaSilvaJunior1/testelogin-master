<?php
    session_start();
    include 'conexao.php';

    if(isset($_SESSION['logado'])){
        header("Location: dashboard.php");
        exit;
    }

    mysqli_query($conn, "CREATE TABLE IF NOT EXISTS `clientes` (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        senha VARCHAR(255) NOT NULL
    )");

    if(isset($_POST['btn'])){
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO `clientes`(nome, email, senha) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sss", $nome, $email, $senha);
        mysqli_stmt_execute($stmt);

        header("Location: index.php");
        exit;
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
    <form action="" method="post">
        <h2>Cadastro</h2>
        <input type="text" name="nome" id="" placeholder="insira seu nome"><br>
        <input type="email" name="email" id="" placeholder="insira seu email"><br>
        <input type="password" name="senha" id="" placeholder="crie uma senha"><br>
        <input type="submit" name="btn" value="Cadastrar">
        <center><p class="possui_conta">já é cadastrado? </p><a href="index.php" class="alternativa">Log-in</a></center>
    </form>
</body>
</html>