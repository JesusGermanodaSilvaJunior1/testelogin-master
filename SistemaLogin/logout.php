<?php

//Autor(Arthur Lazaro Oliveira de Carvalho Bicalho)

session_start();


session_unset();


session_destroy();


header("Location: login.php");
exit();
?>