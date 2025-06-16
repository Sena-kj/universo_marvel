<?php
function conectar_banco() {

    $servidor   = 'localhost'; // Geralmente é 'localhost' para XAMPP
    $usuario    = 'root';     // Usuário padrão do MySQL no XAMPP
    $senha      = '';         // Senha padrão do MySQL no XAMPP (geralmente vazia)
    $banco      = 'universo_marvel'; // ALTERADO: Novo nome do banco de dados

    // Ajuste aqui se o seu MySQL/XAMPP usa uma porta diferente de 3306 (padrão)
    // Se o seu servidor for 'localhost:3307', mantenha como estava no seu original
    // Se for 'localhost' sem porta ou porta 3306, basta 'localhost'
    // Ex: $servidor   = 'localhost:3307';
    // Ou para porta padrão: $servidor   = 'localhost';

    $conn = mysqli_connect($servidor, $usuario, $senha, $banco);

    if (!$conn) {
        // Usa mysqli_connect_error() para detalhes do erro de conexão
        exit("Erro na conexão com o banco de dados: " . mysqli_connect_error());
    }

    // Opcional, mas recomendado: Definir o charset para UTF-8 para evitar problemas com acentuação
    mysqli_set_charset($conn, "utf8");

    return $conn;
}

?>