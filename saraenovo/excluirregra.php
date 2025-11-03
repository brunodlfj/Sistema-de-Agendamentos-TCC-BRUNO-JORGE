<!DOCTYPE html>
<html>
<head>
    <title>Sarae IFFAR UG</title>
    <!-- Import Google Icon Font -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="image/png" href="img/iconejanela.png" />
</head>
<body>
<?php
include "conecta.php";

// Configura o MySQL para não lançar exceções automaticamente
mysqli_report(MYSQLI_REPORT_OFF);

// Pega o ID da atividade a ser excluída do formulário
$idRegra = $_POST['idRegra'];

// Exibe o ID da atividade (apenas para debug; pode ser removido)
echo $idRegra;

// Tenta executar a exclusão
$sql = "DELETE FROM regra WHERE idRegra = $idRegra";
$resultado = mysqli_query($conexao, $sql);

// Tratamento de erros e mensagens de feedback
if ($resultado) {
    echo "<script>
        alert('Regra excluída com sucesso!');
        window.location.href = 'regra.php';
    </script>";
} else {
    // Captura o erro específico do MySQL antes de fechar a conexão
    $erro = mysqli_error($conexao);

    // Exibe uma mensagem genérica de erro
    echo "<script>
        alert('Erro ao excluir a regra: $erro');
        window.location.href = 'regra.php';
    </script>";
}

// Fecha a conexão com o banco
mysqli_close($conexao);
?>
</body>
</html>
