<?php
require_once 'lock.php';      // Garante que o usuário esteja logado
require_once 'functions.php';  // Inclui as funções utilitárias
require_once 'conexao.php';    // Inclui a função de conexão com o banco de dados

//Verifica se o ID do item foi fornecido via GET
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('location:itens.php?codigo=id_nao_fornecido'); // Redireciona com código de erro
    exit;
}

// Receber e validar o ID do item
$item_id_digitado = validarInput($_GET['id']); // Limpa e valida o ID da URL
$item_id = (int)$item_id_digitado; // Garante que é um número inteiro

// Obter o ID do usuário logado da sessão
$usuario_id_logado = $_SESSION['usuario_id']; // ID do usuário logado na sessão

// Conectar ao banco de dados
$conn = conectar_banco(); // Usa sua função conectar_banco()

//  Verificar se o item existe E pertence ao usuário logado antes de excluir
// Este é um passo de segurança crucial
$sql_verificar = "SELECT id FROM itens WHERE id = ? AND usuario_id = ?";
$stmt_verificar = mysqli_prepare($conn, $sql_verificar);

if (!$stmt_verificar) {
    header('location:itens.php?codigo=4'); // Código 4: erro de SQL
    exit;
}

mysqli_stmt_bind_param($stmt_verificar, "ii", $item_id, $usuario_id_logado); // 'ii' para dois inteiros
mysqli_stmt_execute($stmt_verificar);
mysqli_stmt_store_result($stmt_verificar);

if (mysqli_stmt_num_rows($stmt_verificar) == 0) {
    // Item não encontrado ou não pertence ao usuário logado
    header('location:itens.php?codigo=item_nao_permitido_exclusao'); // Novo código para acesso negado à exclusão
    exit;
}
mysqli_stmt_close($stmt_verificar);

//  Excluir o item do banco de dados
$sql_excluir = "DELETE FROM itens WHERE id = ?";
$stmt_excluir = mysqli_prepare($conn, $sql_excluir);

if (!$stmt_excluir) {
    header('location:itens.php?codigo=4'); // Código 4: erro de SQL
    exit;
}

mysqli_stmt_bind_param($stmt_excluir, "i", $item_id); // 'i' para integer

if (!mysqli_stmt_execute($stmt_excluir)) {
    header('location:itens.php?codigo=4'); // Código 4: erro de SQL
    exit;
}

// Redirecionar para a página de listagem de itens com mensagem de sucesso
header('location:itens.php?codigo=item_excluido_sucesso'); // Novo código para sucesso

// Fechar o statement e a conexão
mysqli_stmt_close($stmt_excluir);
mysqli_close($conn);

exit;

?>