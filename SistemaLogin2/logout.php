<?php
/*
 * Projeto: Zeta Transporte
 * Desenvolvedor: Arthur Lázaro
 * Ano: 2026
 */
session_start();

$_SESSION = [];

session_destroy();

header("Location: login.php");
exit;
