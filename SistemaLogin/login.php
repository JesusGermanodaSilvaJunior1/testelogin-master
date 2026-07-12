<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (isset($_SESSION['usuario'])) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta author" content="Arthur Lazaro">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Login</title>

   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container">

    <div class="row justify-content-center mt-5">

        <div class="col-md-4">

            <div class="card shadow">

                <div class="card-header text-center">
                    <h3>Login</h3>
                </div>

                <div class="card-body">

                    <form action="autenticar.php" method="POST">

                        <div class="mb-3">
                            <label class="form-label">Usuário</label>
                            <input
                                type="text"
                                name="username"
                                class="form-control"
                                placeholder="Digite seu usuário"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Senha</label>
                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                placeholder="Digite sua senha"
                                required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Entrar
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>
// Alteração feita por Arthur