<?php
session_start();
include("conexao.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM usuarios WHERE username = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 1) {

        $usuario = $resultado->fetch_assoc();

        if (password_verify($password, $usuario["password"])) {

            $_SESSION["usuario"] = $usuario["username"];
            header("Location: dashboard.php");
            exit();

        } else {
            $mensagem = "Senha incorreta!";
            $tipo = "danger";
        }

    } else {
        $mensagem = "Usuário não encontrado!";
        $tipo = "warning";
    }

} else {
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
    <title>Erro de Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-5">

            <div class="card shadow">

                <div class="card-header bg-dark text-white text-center">
                    <h3>Sistema de Login</h3>
                </div>

                <div class="card-body text-center">

                    <div class="alert alert-<?php echo $tipo; ?>">
                        <strong><?php echo $mensagem; ?></strong>
                    </div>

                    <a href="login.php" class="btn btn-primary">
                        Voltar para o Login
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>