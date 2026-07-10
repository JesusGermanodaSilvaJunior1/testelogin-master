<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <div class="container">
        <h1>Bem-vindo, <?php echo $_SESSION['usuario']; ?>! </h1>
        <p>Você logou com sucesso no sistema.</p>
        <a href="logout.php" class="btn-sair">Sair do Sistema</a>
    </div>

</body>
</html>