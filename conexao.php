<?php
$server = 'localhost';
$db_user = 'root';
$db_pass = '';
$nome_banco = 'clientes';

$conexao = mysqli_connect($server, $db_user, $db_pass, $nome_banco);

if (!$conexao) {
    die("Connection failed: " . mysqli_connect_error());
}