<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Dashboard - Universo Marvel</title>
    </head>
<body>

    <?php
        // Inclui o arquivo lock.php para proteger a página
        require_once 'lock.php'; 
        // Inclui o arquivo de funções para quaisquer utilidades
        require_once 'functions.php'; 
    ?>

    <h1>Bem-vindo(a) ao seu Universo Marvel!</h1>

    <nav>
        <a href="dashboard.php">Início</a> |
        <a href="itens.php">Meus Itens Marvel</a> |
        <a href="novo_item.php">Adicionar Novo Item</a> |
        <a href="logout.php">Sair</a>
    </nav>

    <h2>Olá, <?= $_SESSION['usuario']; ?>!</h2>
    <h3>Explore e gerencie seus itens colecionáveis da Marvel.</h3>

    <section class="atalhos">
        <h2>Ações Rápidas:</h2>
        <ul>
            <li><a href="novo_item.php">Cadastrar Novo Item da Marvel</a></li>
            <li><a href="itens.php">Ver Meus Itens Cadastrados</a></li>
            </ul>
    </section>

    <footer>
        <p>&copy; 2025 Universo Marvel. Todos os direitos reservados.</p>
    </footer>

</body>
</html>
