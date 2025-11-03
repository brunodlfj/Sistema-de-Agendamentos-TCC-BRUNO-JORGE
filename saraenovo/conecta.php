<?php
    $bdServidor = 'localhost';
    $bdUsuario = 'root';
    $bdSenha = '';
    $bdBanco = 'sarae';
    // Cria a conexão
    $conexao = mysqli_connect($bdServidor, $bdUsuario, $bdSenha, $bdBanco);

    // Verifica se a conexão foi bem-sucedida
    if ($conexao === false)
{	
	echo "Problemas para conectar no banco. Erro: ";
	echo mysqli_connect_error();	
}

?>
