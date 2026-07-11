<?php
    $serverbd = "localhost";
    $userbd = "root";
    $senhabd ="";
    $nomebd = "clientes";
    $connbd = "";

    $connbd = mysqli_connect($serverbd, $userbd, $senhabd);

    if(!$connbd){
        echo '<center>Falha na conexão!</center>';
    } 

    $sqlbd = "CREATE DATABASE IF NOT EXISTS $nomebd";

    $sqltb = "CREATE TABLE IF NOT EXISTS novos(
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(50) NOT NULL,
        senha VARCHAR(255) NOT NULL 
    )";

    mysqli_query($connbd, $sqlbd);
    mysqli_select_db($connbd, $nomebd);
    mysqli_query($connbd, $sqltb);

?>