<?php

// Inicia a sessão se ainda não estiver iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verifica se o ID do usuário está definido na sessão
// Se não estiver logado, redireciona para a página de login com código de acesso não autorizado
if (!isset($_SESSION['usuario_id'])) {
    header('location:index.php?codigo=1'); // Código 1: acesso não autorizado
    exit(); // É crucial chamar exit() após um redirecionamento
}
?>