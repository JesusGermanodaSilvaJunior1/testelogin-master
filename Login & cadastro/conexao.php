<?php
    $host = "localhost";
    $nomebd = "usuarios";
    $senhabd = "";
    $user = "root";

    $conn = mysqli_connect($host, $user, $senhabd);
    mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS `$nomebd`");
    mysqli_select_db($conn, $nomebd);

?>