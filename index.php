<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Login - Universo Marvel</title>
    </head>
<body>

    <h1>Bem-vindo(a) ao Universo Marvel!</h1>

    <nav>
        <a href="index.php">Login</a> |
        <a href="cadastro.php">Cadastre-se</a>
        </nav>

    <?php
        // Incluir o arquivo de funções para usar validar_codigo()
        require_once 'functions.php'; // Adaptação do seu projeto base 

        // Chama a função para exibir mensagens de erro/sucesso baseadas em códigos
        validar_codigo(); // Adaptação do seu projeto base 
    ?>

    <h2>Para acessar as aventuras da Marvel, informe seus dados:</h2>

    <form action="validar.php" method="post">
        <p>
            <label for="usuario">Usuário:</label><br>
            <input type="text" name="usuario" id="usuario" required>
        </p>

        <p>
            <label for="senha">Senha:</label><br>
            <input type="password" name="senha" id="senha" required>
        </p>

        <button type="submit">Entrar</button>
    </form>

    <p>Ainda não tem conta? <a href="cadastro.php">Cadastre-se aqui!</a></p>

</body>
</html>