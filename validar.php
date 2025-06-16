<?php

//funcoes em
require_once 'functions.php';
require_once 'conexao.php';

// Inicia a sessão se ainda não estiver iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Se chegarmos na página via GET, retornaremos à home
if (form_nao_enviado()) { // Usa a função do seu functions.php
    header('location:index.php?codigo=1'); // Código 1: acesso não autorizado / formulário não submetido corretamente
    exit;
}

// Receber dados do formulário de login
$usuario_digitado = validarInput($_POST['usuario']); // Limpa e valida o input
$senha_digitada   = $_POST['senha'];               // A senha em texto puro para verificação

// Se há campos em branco no formulário de login
if (empty($usuario_digitado) || empty($senha_digitada)) {
    header('location:index.php?codigo=2'); // Código 2: form não submetido / campos em branco
    exit;
}

// Acesso ao banco de dados e verificação de credenciais
$conn = conectar_banco(); // Usa sua função conectar_banco()

// Prepara a consulta para buscar o usuário pelo login
// Não buscamos a senha diretamente, pois vamos verificá-la com password_verify
$sql = "SELECT id, login, senha FROM usuarios WHERE login = ?";
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) { // Se ocorreu um erro ao preparar a consulta SQL
    header('location:index.php?codigo=4'); // Código 4: erro de SQL
    exit;
}

// Realiza a associação (bind) do parâmetro (login) na consulta
mysqli_stmt_bind_param($stmt, "s", $usuario_digitado); // 's' para string

// Executa a consulta
if (!mysqli_stmt_execute($stmt)) { // Se retornou false, é porque ocorreu algum erro com o SQL
    header('location:index.php?codigo=4'); // Código 4: erro de SQL
    exit;
}

// Armazena o resultado da consulta
mysqli_stmt_store_result($stmt);

// Se encontrou exatamente 1 linha (usuário encontrado)
if (mysqli_stmt_num_rows($stmt) == 1) {
    mysqli_stmt_bind_result($stmt, $usuario_id, $login_db, $senha_hash_db);
    mysqli_stmt_fetch($stmt); // Obtém os resultados

    // Verifica a senha digitada com o hash armazenado no banco de dados
    if (password_verify($senha_digitada, $senha_hash_db)) {
        // Senha correta: iniciar a sessão e registrar dados
        session_start();
        $_SESSION['usuario_id'] = $usuario_id;
        $_SESSION['usuario']    = $login_db;

        // Redirecionar para a página restrita (dashboard)
        header('location:dashboard.php');
        exit;
    } else {
        // Senha incorreta
        header('location:index.php?codigo=3'); // Código 3: usuário ou senha inválidos
        exit;
    }
} else {
    // Usuário não encontrado
    header('location:index.php?codigo=3'); // Código 3: usuário ou senha inválidos
    exit;
}

// Fechar o statement e a conexão
mysqli_stmt_close($stmt);
mysqli_close($conn);

?>