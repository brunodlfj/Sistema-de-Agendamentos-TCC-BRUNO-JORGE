<?php
include "conecta.php";

// Configura o MySQL para não lançar exceções automaticamente
mysqli_report(MYSQLI_REPORT_OFF);

// Pega o ID do dia contemplado a ser excluído do formulário
$idContemplado = $_POST['idContemplado'];

// Tenta executar a exclusão
$sql = "DELETE FROM diacontemplado WHERE idContemplado = $idContemplado";
$resultado = mysqli_query($conexao, $sql);

// Verifica se a exclusão foi bem-sucedida ou se ocorreu um erro
if ($resultado) {
    echo "<script>
        alert('Dia contemplado excluído com sucesso!');
        window.location.href = 'inicioadm.php';
    </script>";
} else {
    // Captura o erro específico do MySQL
    $erro = mysqli_error($conexao);

    // Verifica se o erro está relacionado à chave estrangeira
    if (strpos($erro, 'a foreign key constraint fails') !== false) {
        echo "<script>
            alert('Erro: Não é possível excluir este dia contemplado, pois ele já possui agendamentos associados. Cancele os agendamentos feitos para que seja possível a exclusão!');
            window.location.href = 'inicioadm.php';
        </script>";
    } else {
        echo "<script>
            alert('Erro ao excluir o dia contemplado: $erro');
            window.location.href = 'inicioadm.php';
        </script>";
    }
}

// Fecha a conexão com o banco
mysqli_close($conexao);
?>
