<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Adicionar Novo Item Marvel - Universo Marvel</title>
    </head>
<body>

    <?php
        // Inclui o arquivo lock.php para proteger a página
        require_once 'lock.php';
        // Inclui o arquivo de funções para quaisquer utilidades
        require_once 'functions.php';
    ?>

    <h1>Adicionar Novo Item ao seu Universo Marvel</h1>

    <nav>
        <a href="dashboard.php">Início</a> |
        <a href="itens.php">Meus Itens Marvel</a> |
        <a href="novo_item.php">Adicionar Novo Item</a> |
        <a href="logout.php">Sair</a>
    </nav>

    <h2>Preencha os dados do novo item da Marvel:</h2>

    <?php
        // Chama a função para exibir mensagens de erro/sucesso baseadas em códigos
        validar_codigo();
    ?>

    <form action="processa_novo_item.php" method="post">
        <p>
            <label for="titulo">Título/Nome do Item:</label><br>
            <input type="text" name="titulo" id="titulo" required>
        </p>
        <p>
            <label for="descricao">Descrição:</label><br>
            <textarea name="descricao" id="descricao" rows="5" required></textarea>
        </p>
        <button type="submit">Cadastrar Item</button>
    </form>

    <p><a href="itens.php">Voltar para Meus Itens</a></p>

    <footer>
        <p>&copy; 2025 Universo Marvel. Todos os direitos reservados.</p>
    </footer>

</body>
</html>
