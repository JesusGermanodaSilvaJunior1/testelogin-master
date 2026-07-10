<?php

    $serverbd = "localhost";
    $userbd = "root";
    $senhabd ="";
    $nomebd = "clientes";
    $connbd = "";

    $connbd = mysqli_connect($serverbd, $userbd, $senhabd, $nomebd);

    if(!$connbd){
        echo '<center>Falha na conexão!</center>';
    } 

        $sql = "CREATE TABLE IF NOT EXISTS novos (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nome VARCHAR(50) NOT NULL, 
                senha VARCHAR(255) NOT NULL)";

?>