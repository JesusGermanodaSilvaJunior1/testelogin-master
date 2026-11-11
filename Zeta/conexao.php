<?php
    $host    = "localhost";
    $nomebd  = "zeta_transporte";
    $user    = "root";
    $senhabd = "";

    try {
        $pdo = new PDO(
            "mysql:host=$host;dbname=$nomebd;charset=utf8mb4",
            $user,
            $senhabd,
            [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false
            ]
        );
    } catch (PDOException $e) {
        error_log("Erro de conexão: " . $e->getMessage());
        die("Erro: " . $e->getMessage());    }
?>
