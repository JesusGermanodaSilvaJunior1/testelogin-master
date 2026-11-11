<?php
    session_start();
    include 'conexao.php';
 
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Pragma: no-cache");
 
    if(!isset($_SESSION['logado'])){
        header("Location: index.php");
        exit;
    }
 
    $nome = $_SESSION['nome'];
 
    $sql = "SELECT nome FROM `clientes` WHERE nome = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $nome);
    mysqli_stmt_execute($stmt);
 
    $result = mysqli_stmt_get_result($stmt);
    $cliente = mysqli_fetch_assoc($result);
 
    if(!$cliente){
        session_unset();
        session_destroy();
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
    <title>Dashboard</title>
</head>
<body>
    <h2>Olá, <?php echo htmlspecialchars($nome); ?>!</h2>
    <a href="logout.php">Log out</a>
</body>
</html>