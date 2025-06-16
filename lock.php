<?php

// Inicia a sessão se ainda não estiver iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_id'])) {
    header('location:index.php?codigo=1'); // Código 1: acesso não autorizado
    exit(); 
}
?>
