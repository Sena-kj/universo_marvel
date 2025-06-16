<?php
function conectar_banco() {

    $servidor   = 'localhost'; 
    $usuario    = 'root';     
    $senha      = '';      
    $banco      = 'universo_marvel'; 

    $conn = mysqli_connect($servidor, $usuario, $senha, $banco);

    if (!$conn) {
      
        exit("Erro na conexão com o banco de dados: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8");

    return $conn;
}

?>
