<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta author="Vitor Alves Vieira Santos">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Dashboard</title>
</head>
<body>
   <form action="" method="post">
    <div name="popup" class=" border border-info shadow p-3 ">
        <p class="text-center h3"><?php echo 'Olá, seja bem vindo! <br>' . $_SESSION["nome"]; ?></p>
    </div>
    <input type="submit" value="Logout" name="logout"class="text-center bg bg-danger text-white 
                                                             border border-danger-subtle position-absolute translate-middle
                                                             start-50 mt-5 rounded h5 p-2">
   </form> 
</body>
</html>

<?php
    include("conexao.php");

    if(isset($_POST["logout"])){
        session_destroy();
        header("Location: index.php");
    }
?>