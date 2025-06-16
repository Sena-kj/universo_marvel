<?php
require_once 'lock.php';      // Garante que o usuário esteja logado 
require_once 'functions.php';  // Inclui as funções utilitárias
require_once 'conexao.php';    // Inclui a função de conexão com o banco de dados 


if (form_nao_enviado()) { 
    header('location:itens.php?codigo=0'); 
    exit;
}


$item_id_digitado    = validarInput($_POST['item_id']); 
$titulo_digitado     = validarInput($_POST['titulo']);
$descricao_digitada  = validarInput($_POST['descricao']);

//  Validação de campos em branco e ID
if (empty($item_id_digitado) || empty($titulo_digitado) || empty($descricao_digitada)) {
   
    header('location:itens.php?codigo=2'); // Código 2: campos em branco
    exit;
}

// Garante que o ID do item seja um número inteiro
$item_id = (int)$item_id_digitado;

//Obter o ID do usuário logado da sessão
$usuario_id_logado = $_SESSION['usuario_id']; 

//  Conectar ao banco de dados
$conn = conectar_banco(); 

$sql_verificar = "SELECT id FROM itens WHERE id = ? AND usuario_id = ?"; // Consulta a tabela 'itens' 
$stmt_verificar = mysqli_prepare($conn, $sql_verificar);

if (!$stmt_verificar) {
    header('location:itens.php?codigo=4'); // Código 4: erro de SQL
    exit;
}

mysqli_stmt_bind_param($stmt_verificar, "ii", $item_id, $usuario_id_logado); 
mysqli_stmt_execute($stmt_verificar);
mysqli_stmt_store_result($stmt_verificar);

if (mysqli_stmt_num_rows($stmt_verificar) == 0) {
    // Item não encontrado ou não pertence ao usuário logado
    header('location:itens.php?codigo=item_nao_permitido_edicao'); 
    exit;
}
mysqli_stmt_close($stmt_verificar);

// Atualizar o item no banco de dados
$sql_atualizar = "UPDATE itens SET titulo = ?, descricao = ? WHERE id = ?"; // Atualiza 'titulo' e 'descricao' da tabela 'itens' 
$stmt_atualizar = mysqli_prepare($conn, $sql_atualizar);

if (!$stmt_atualizar) {
    header('location:itens.php?codigo=4'); // Código 4: erro de SQL
    exit;
}


mysqli_stmt_bind_param($stmt_atualizar, "ssi", $titulo_digitado, $descricao_digitada, $item_id);

if (!mysqli_stmt_execute($stmt_atualizar)) {
    header('location:itens.php?codigo=4'); // Código 4: erro de SQL
    exit;
}

// Redirecionar para a página de listagem de itens com mensagem de sucesso
header('location:itens.php?codigo=item_editado_sucesso'); // Novo código para sucesso


mysqli_stmt_close($stmt_atualizar);
mysqli_close($conn);

exit;

?>
