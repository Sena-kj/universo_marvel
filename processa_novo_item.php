<?php
require_once 'lock.php';    
require_once 'functions.php';  
require_once 'conexao.php';    

//  Verifica se o formulário foi enviado via POST
if (form_nao_enviado()) {
    header('location:novo_item.php?codigo=0'); // Redireciona com código de erro geral
    exit;
}

//  Receber e validar dados do formulário
$titulo_digitado    = validarInput($_POST['titulo']);
$descricao_digitada = validarInput($_POST['descricao']);

//  Validação de campos em branco
if (empty($titulo_digitado) || empty($descricao_digitada)) {
    header('location:novo_item.php?codigo=2'); // Código 2: campos em branco
    exit;
}

//  Obter o ID do usuário logado da sessão
$usuario_id = $_SESSION['usuario_id'];

// 5. Conectar ao banco de dados
$conn = conectar_banco();

// Inserir o novo item no banco de dados
$sql_inserir = "INSERT INTO itens (usuario_id, titulo, descricao) VALUES (?, ?, ?)";
$stmt_inserir = mysqli_prepare($conn, $sql_inserir);

if (!$stmt_inserir) {
    header('location:novo_item.php?codigo=4'); // Código 4: erro de SQL
    exit;
}

mysqli_stmt_bind_param($stmt_inserir, "iss", $usuario_id, $titulo_digitado, $descricao_digitada);

if (!mysqli_stmt_execute($stmt_inserir)) {
    header('location:novo_item.php?codigo=4'); // Código 4: erro de SQL
    exit;
}

//  Redirecionar para a página de listagem de itens com mensagem de sucesso
header('location:itens.php?codigo=item_cadastrado_sucesso'); // Novo código para sucesso

mysqli_stmt_close($stmt_inserir);
mysqli_close($conn);

exit;

?>
