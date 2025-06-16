<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Meus Itens Marvel - Universo Marvel</title>
    </head>
<body>

    <?php
        require_once 'lock.php';      // Garante que o usuário esteja logado
        require_once 'functions.php';  // Inclui as funções utilitárias
        require_once 'conexao.php';    // Inclui a função de conexão com o banco de dados
    ?>

    <h1>Meus Itens do Universo Marvel</h1>

    <nav>
        <a href="dashboard.php">Início</a> |
        <a href="itens.php">Meus Itens Marvel</a> |
        <a href="novo_item.php">Adicionar Novo Item</a> |
        <a href="logout.php">Sair</a>
    </nav>

    <h2>Seus Itens Cadastrados</h2>
    <p>Aqui estão todos os itens da Marvel que você adicionou:</p>

    <?php
        validar_codigo(); // Exibe mensagens de sucesso/erro
    ?>

    <div class="itens-lista">
        <?php
        // Obter o ID do usuário logado da sessão
        $usuario_id_logado = $_SESSION['usuario_id'];

        // Conectar ao banco de dados
        $conn = conectar_banco();

        // Consulta para buscar todos os itens do usuário logado, ordenados pela data de criação
        $sql = "SELECT id, titulo, descricao, data_criacao FROM itens WHERE usuario_id = ? ORDER BY data_criacao DESC";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $usuario_id_logado); // 'i' para integer

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt); // Armazena o resultado

                if (mysqli_stmt_num_rows($stmt) > 0) {
                    // Se houver itens, bind dos resultados
                    mysqli_stmt_bind_result($stmt, $item_id, $titulo, $descricao, $data_criacao);

                    // Loop para exibir cada item
                    while (mysqli_stmt_fetch($stmt)) {
                        // Formatar a data para exibição
                        $data_formatada = date('d/m/Y H:i', strtotime($data_criacao));
                        ?>
                        <div class="item-card">
                            <h3><?= htmlspecialchars($titulo); ?></h3>
                            <p><strong>Descrição:</strong> <?= htmlspecialchars($descricao); ?></p>
                            <p><em>Data de Criação: <?= $data_formatada; ?></em></p>
                            <div class="item-acoes">
                                <a href="editar_item.php?id=<?= $item_id; ?>">Editar</a>
                                <a href="excluir_item.php?id=<?= $item_id; ?>" onclick="return confirm('Tem certeza que deseja excluir este item?');">Excluir</a>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    // Nenhum item encontrado para este usuário
                    echo '<p class="no-items">Você ainda não cadastrou nenhum item da Marvel. Que tal <a href="novo_item.php">adicionar um agora</a>?</p>';
                }
            } else {
                // Erro na execução da consulta
                echo '<p class="erro-bd">Ocorreu um erro ao buscar os itens. Por favor, tente novamente mais tarde.</p>';
                // Opcional: registrar o erro em um log, não exibir detalhes para o usuário final
            }
            mysqli_stmt_close($stmt); // Fecha o statement
        } else {
            // Erro na preparação da consulta
            echo '<p class="erro-bd">Ocorreu um erro na preparação da consulta. Por favor, contate o suporte.</p>';
            // Opcional: registrar o erro
        }

        mysqli_close($conn); // Fecha a conexão
        ?>
    </div>

    <p class="add-new-item-link">
        <a href="novo_item.php">Adicionar Novo Item da Marvel</a>
    </p>

    <footer>
        <p>&copy; 2025 Universo Marvel. Todos os direitos reservados.</p>
    </footer>

</body>
</html>