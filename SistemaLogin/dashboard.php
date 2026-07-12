<?php
session_start();


if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta author" content="Arthur Lazaro">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-header bg-primary text-white">
            <h3>Painel do Sistema</h3>
        </div>

        <div class="card-body">

            <h2>Bem-vindo, <?php echo $_SESSION["usuario"]; ?>!</h2>

            <p>Você fez login com sucesso.</p>

            <a href="logout.php" class="btn btn-danger">
                Sair
            </a>

        </div>

    </div>

</div>

</body>
</html>