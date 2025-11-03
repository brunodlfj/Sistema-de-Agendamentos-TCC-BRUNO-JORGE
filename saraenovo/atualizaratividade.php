<?php
include "conecta.php";

// Recebe os dados do formulário
$idAtividade = $_POST['idAtividade'];
$nome = $_POST['nome'];
$diadasemana = $_POST['diadasemana'];
$situacao = $_POST['situacao'];

// Atualiza a atividade no banco de dados
$sql = "UPDATE atividade SET diadasemana='$diadasemana', nome='$nome', situacao='$situacao' WHERE idAtividade='$idAtividade'";
$resultado = mysqli_query($conexao, $sql);

// Fecha a conexão
mysqli_close($conexao);

// Verifica se a atualização foi bem-sucedida
if ($resultado) {
    echo "<script>
        alert('Atividade atualizada com sucesso!');
        window.location.href = 'inicioprofessor.php';
    </script>";
} else {
    echo "<script>
        alert('Erro ao atualizar a atividade. Tente novamente.');
        window.history.back();
    </script>";
}
?>
