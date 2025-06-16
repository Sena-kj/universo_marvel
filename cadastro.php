<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Cadastro - Universo Marvel</title>
    </head>
<body>

    <h1>Crie sua Conta no Universo Marvel!</h1>

    <nav>
        <a href="index.php">Login</a> |
        <a href="cadastro.php">Cadastre-se</a>
    </nav>

    <?php
        // Incluir o arquivo de funções para usar validar_codigo()
        require_once 'functions.php';

        // Chama a função para exibir mensagens de erro/sucesso baseadas em códigos
        validar_codigo();
    ?>

    <h2>Junte-se aos heróis e vilões da Marvel!</h2>

    <form action="processa_cadastro.php" method="post">
        <p>
            <label for="usuario">Nome de Usuário (Login):</label><br>
            <input type="text" name="usuario" id="usuario" required>
        </p>

        <p>
            <label for="email">E-mail:</label><br>
            <input type="email" name="email" id="email" required>
        </p>

        <p>
            <label for="senha">Senha:</label><br>
            <input type="password" name="senha" id="senha" required>
        </p>

        <p>
            <label for="confirmar_senha">Confirmar Senha:</label><br>
            <input type="password" name="confirmar_senha" id="confirmar_senha" required>
        </p>

        <button type="submit">Cadastrar</button>
    </form>

    <p>Já tem conta? <a href="index.php">Faça Login aqui!</a></p>

</body>
</html>