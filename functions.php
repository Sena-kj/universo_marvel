<?php
// Função para verificar se o formulário foi enviado via POST
function form_nao_enviado() {
    return $_SERVER['REQUEST_METHOD'] !== 'POST';
}

// Função para validar e limpar dados de entrada
function validarInput($dado) {
    $dado = trim($dado);
    $dado = stripslashes($dado);
    $dado = htmlspecialchars($dado);
    return $dado;
}

// Função para exibir mensagens baseadas em códigos
function validar_codigo() {
    if (isset($_GET['codigo']) && !empty($_GET['codigo'])) {
        $codigo = $_GET['codigo'];
        $msg = '';
        $tipo_mensagem = 'info'; // Tipo padrão para mensagens (ex: info, sucesso, erro)

        switch ($codigo) {
            case '0':
                $msg = "<h3>Ocorreu um erro inesperado. Por favor, tente novamente.</h3>";
                $tipo_mensagem = 'erro';
                break;
            case '1':
                $msg = "<h3>Acesso não autorizado. Por favor, faça login.</h3>";
                $tipo_mensagem = 'erro';
                break;
            case '2':
                $msg = "<h3>Por favor, preencha todos os campos.</h3>";
                $tipo_mensagem = 'erro';
                break;
            case '3':
                $msg = "<h3>Usuário ou senha inválidos.</h3>";
                $tipo_mensagem = 'erro';
                break;
            case '4':
                $msg = "<h3>Ocorreu um erro ao acessar o banco de dados. Por favor, tente novamente mais tarde.</h3>";
                $tipo_mensagem = 'erro';
                break;
            
            case 'senhas_nao_conferem':
                $msg = "<h3>As senhas digitadas não conferem. Por favor, tente novamente.</h3>";
                $tipo_mensagem = 'erro';
                break;
            case 'usuario_ou_email_existente':
                $msg = "<h3>Este nome de usuário ou e-mail já está em uso.</h3>";
                $tipo_mensagem = 'erro';
                break;
            case 'cadastro_sucesso':
                $msg = "<h3>Cadastro realizado com sucesso! Faça login para continuar.</h3>";
                $tipo_mensagem = 'sucesso';
                break;
            case 'item_cadastrado_sucesso':
                $msg = "<h3>Item da Marvel cadastrado com sucesso!</h3>";
                $tipo_mensagem = 'sucesso';
                break;
            case 'item_nao_permitido_edicao':
                $msg = "<h3>Você não tem permissão para editar este item ou ele não existe.</h3>";
                $tipo_mensagem = 'erro';
                break;
            case 'item_editado_sucesso':
                $msg = "<h3>Item da Marvel editado com sucesso!</h3>";
                $tipo_mensagem = 'sucesso';
                break;
            case 'id_nao_fornecido':
                $msg = "<h3>ID do item não fornecido.</h3>";
                $tipo_mensagem = 'erro';
                break;
            case 'item_nao_permitido_exclusao':
                $msg = "<h3>Você não tem permissão para excluir este item ou ele não existe.</h3>";
                $tipo_mensagem = 'erro';
                break;
            case 'item_excluido_sucesso':
                $msg = "<h3>Item da Marvel excluído com sucesso!</h3>";
                $tipo_mensagem = 'sucesso';
                break;
            case 'item_nao_encontrado':
                $msg = "<h3>Item não encontrado.</h3>";
                $tipo_mensagem = 'erro';
                break;
            case 'erro_acesso':
                $msg = "<h3>Acesso negado. Você não tem permissão para acessar esta página.</h3>";
                $tipo_mensagem = 'erro';
                break;
            case 'erro_sql':
                $msg = "<h3>Ocorreu um erro no banco de dados. Por favor, tente novamente mais tarde. Se o problema persistir, contacte o suporte.</h3>";
                $tipo_mensagem = 'erro';
                break;
            default:
                $msg = "<h3>Ocorreu um erro desconhecido.</h3>";
                $tipo_mensagem = 'info';
        }
        
        echo "<h3 class='mensagem {$tipo_mensagem}'>{$msg}</h3>";
    }
}

?>
