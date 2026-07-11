<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta author="Vitor Alves Vieira Santos">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Login</title>
</head>
<body>  
    <main>
        <div id="form" 
        class=" 
        text-center
        w-25 h-50
        position-absolute top-50 start-50 translate-middle">
            <h1>Login</h1>
            <form action="" method="post">
                <input type="text" name="nome" placeholder="Seu nome de usuário" required
                class="form-control 
                border border-primary"> <br><br>
                <input type="password" name="senha" placeholder="Sua senha" required
                class="form-control 
                border border-primary"> <br><br>
                <input type="submit" value="Entrar" name="entrar" 
                class="
                w-50
                btn btn-primary">
            </form>
        </div>
    </main>
</body>
</html>

<?php
    include("conexao.php");

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $nome = $_POST['nome'];
        $senha = $_POST['senha'];

        $_SESSION["nome"] = $nome;
        $_SESSION["senha"] = $senha;

        $sqlbd = "SELECT * FROM novos WHERE nome = '$nome' AND senha = '$senha'";
        $resultado = mysqli_query($connbd, $sqlbd);

        if(!$resultado){
                    echo 'Erro na consulta: ' . mysqli_error($connbd);
        } else {
            if (mysqli_num_rows($resultado) > 0) {
                header("Location: dashboard.php");
                exit;
            } 
            else {
            echo '<p class="text-center h4 bg bg-danger border border-danger-subtle rounded p-1 text-white
                            w-25 mt-5 position-absolute start-50 translate-middle"> Erro. <br> Usuário não encontrado!</p>';
            }
        }
    }
?>