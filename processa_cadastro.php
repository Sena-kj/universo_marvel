<?php
require_once 'functions.php'; // Inclui as funções utilitárias 
require_once 'conexao.php';   // Inclui a função de conexão com o banco de dados 

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

//  Verifica se o formulário foi enviado via POST
if (form_nao_enviado()) { 
    header('location:cadastro.php?codigo=0'); 
    exit;
}

// Receber dados do formulário de cadastro
$usuario_digitado     = validarInput($_POST['usuario']); 
$email_digitado       = validarInput($_POST['email']); 
$senha_digitada       = $_POST['senha'];              
$confirmar_senha      = $_POST['confirmar_senha'];

// Validação de campos em branco
if (empty($usuario_digitado) || empty($email_digitado) || empty($senha_digitada) || empty($confirmar_senha)) {
    header('location:cadastro.php?codigo=2'); 
    exit;
}

//  Validação de senhas coincidentes
if ($senha_digitada !== $confirmar_senha) {
    header('location:cadastro.php?codigo=senhas_nao_conferem'); 
    exit;
}

// Hash da senha para segurança
$senha_hash = password_hash($senha_digitada, PASSWORD_DEFAULT); 

//Conectar ao banco de dados
$conn = conectar_banco(); 

// Verificar se o login ou e-mail já existem 
$sql_verificar = "SELECT id FROM usuarios WHERE login = ? OR email = ?"; // Verifica se login ou e-mail já existem no banco de dados 
$stmt_verificar = mysqli_prepare($conn, $sql_verificar);

if (!$stmt_verificar) {
    header('location:cadastro.php?codigo=4'); // Erro de SQL 
    exit;
}

mysqli_stmt_bind_param($stmt_verificar, "ss", $usuario_digitado, $email_digitado); 
mysqli_stmt_execute($stmt_verificar);
mysqli_stmt_store_result($stmt_verificar);

if (mysqli_stmt_num_rows($stmt_verificar) > 0) {
    header('location:cadastro.php?codigo=usuario_ou_email_existente'); 
    exit;
}
mysqli_stmt_close($stmt_verificar);

// Inserir o novo usuário no banco de dados
$sql_inserir = "INSERT INTO usuarios (login, senha, email) VALUES (?, ?, ?)"; 
$stmt_inserir = mysqli_prepare($conn, $sql_inserir);

if (!$stmt_inserir) {
    header('location:cadastro.php?codigo=4'); // Erro de SQL 
    exit;
}

mysqli_stmt_bind_param($stmt_inserir, "sss", $usuario_digitado, $senha_hash, $email_digitado); 

if (!mysqli_stmt_execute($stmt_inserir)) {
    header('location:cadastro.php?codigo=4'); // Erro de SQL 
    exit;
}

//  Redirecionar para a página de login com mensagem de sucesso
header('location:index.php?codigo=cadastro_sucesso'); // Novo código: cadastro realizado com sucesso

mysqli_close($conn);

exit;

?>
