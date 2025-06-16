<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Editar Item Marvel - Universo Marvel</title>
    </head>
<body>

    <?php
        // Inclui o arquivo lock.php para proteger a página
        require_once 'lock.php';
        // Inclui o arquivo de funções para quaisquer utilidades
        require_once 'functions.php';
        // Inclui o arquivo de conexão com o banco de dados
        require_once 'conexao.php'; 
    ?>

    <h1>Editar Item do seu Universo Marvel</h1>

    <nav>
        <a href="dashboard.php">Início</a> |
        <a href="itens.php">Meus Itens Marvel</a> |
        <a href="novo_item.php">Adicionar Novo Item</a> |
        <a href="logout.php">Sair</a>
    </nav>

    <h2>Edite os detalhes do item:</h2>

    <?php
        // Chama a função para exibir mensagens de erro/sucesso baseadas em códigos
        validar_codigo(); 

        // Lógica para buscar e preencher os dados do item
        $item_id = null;
        $titulo_item = '';
        $descricao_item = '';

        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $item_id = (int)$_GET['id']; // Garante que é um número inteiro e sanitiza o input

            $conn = conectar_banco(); // Usa sua função para conectar ao banco de dados 

            // Prepara a consulta para buscar o item
            // Adicionamos a condição para verificar se o item pertence ao usuário logado
            // Assumimos que a tabela é 'itens' e que 'usuario_id' é uma chave estrangeira 
            $sql = "SELECT titulo, descricao, usuario_id FROM itens WHERE id = ? AND usuario_id = ?"; // 
            $stmt = mysqli_prepare($conn, $sql);

            if ($stmt) {
                // Associa os parâmetros da consulta
                mysqli_stmt_bind_param($stmt, "ii", $item_id, $_SESSION['usuario_id']); 

                // Executa a consulta
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt); // Armazena o resultado da consulta

                if (mysqli_stmt_num_rows($stmt) == 1) {// Verifica se encontrou exatamente 1 item
                    mysqli_stmt_bind_result($stmt, $titulo_item, $descricao_item, $usuario_id_do_item);
                    mysqli_stmt_fetch($stmt); // Obtém os resultados

                    // Aqui você pode adicionar uma checagem extra, embora a query já faça isso
                    if ($usuario_id_do_item != $_SESSION['usuario_id']) {
                        // Se por algum motivo o item não pertencer ao usuário logado, redireciona
                        header('location:itens.php?codigo=erro_acesso'); // Crie um código para isso em functions.php
                        exit();
                    }
                } else {
                    // Item não encontrado ou não pertence ao usuário
                    header('location:itens.php?codigo=item_nao_encontrado'); 
                    exit();
                }
                mysqli_stmt_close($stmt); 
            } else {
                // Erro ao preparar a consulta
                header('location:itens.php?codigo=erro_sql'); 
                exit();
            }
            mysqli_close($conn); 
        } else {
            // ID do item não fornecido na URL
            header('location:itens.php?codigo=id_nao_fornecido'); 
            exit();
        }
    ?>

    <form action="processa_edicao_item.php" method="post">
        <input type="hidden" id="item_id" name="item_id" value="<?= $item_id; ?>">

        <p>
            <label for="titulo">Título/Nome do Item:</label><br>
            <input type="text" name="titulo" id="titulo" value="<?= htmlspecialchars($titulo_item); ?>" required>
        </p>
        <p>
            <label for="descricao">Descrição:</label><br>
            <textarea name="descricao" id="descricao" rows="5" required><?= htmlspecialchars($descricao_item); ?></textarea>
        </p>
        <button type="submit">Salvar Alterações</button>
    </form>

    <p><a href="itens.php">Voltar para Meus Itens</a></p>

    <footer>
        <p>&copy; 2025 Universo Marvel. Todos os direitos reservados.</p>
    </footer>

</body>
</html>
