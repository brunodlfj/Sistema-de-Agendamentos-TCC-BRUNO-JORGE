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
$idAtividade = $_POST['idAtividade'];

// Exibe o ID da atividade (apenas para debug; pode ser removido)
echo $idAtividade;

// Tenta executar a exclusão
$sql = "DELETE FROM atividade WHERE idAtividade = $idAtividade";
$resultado = mysqli_query($conexao, $sql);

// Tratamento de erros e mensagens de feedback
if ($resultado) {
    echo "<script>
        alert('Atividade excluída com sucesso!');
        window.location.href = 'inicioprofessor.php';
    </script>";
} else {
    // Captura o erro específico do MySQL antes de fechar a conexão
    $erro = mysqli_error($conexao);

    // Verifica se o erro está relacionado à chave estrangeira
    if (strpos($erro, 'a foreign key constraint fails') !== false) {
        echo "<script>
            alert('Erro: Não é possível excluir esta atividade, pois ela já possui agendamentos associados. Caso deseje que a atividade pare de receber novos agendamentos, inative a mesma!.');
            window.location.href = 'inicioprofessor.php';
        </script>";
    } else {
        echo "<script>
            alert('Erro ao excluir a atividade: $erro');
            window.location.href = 'inicioprofessor.php';
        </script>";
    }
}

// Fecha a conexão com o banco
mysqli_close($conexao);
?>
</body>
</html>
