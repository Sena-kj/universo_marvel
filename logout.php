<?php
session_start(); // Inicia a sessão para poder manipulá-la
unset($_SESSION); // Remove todas as variáveis de sessão (limpa o array $_SESSION)
session_destroy(); // Destrói todos os dados registrados na sessão
header('location:index.php'); // Redireciona para a página inicial (login)
exit(); // Finaliza a execução do script

?>