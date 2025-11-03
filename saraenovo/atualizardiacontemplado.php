<?php
include "conecta.php";

// Recebe os dados do formulário
$idContemplado = $_POST['idContemplado'];
$dia = $_POST['dia'];
$quantidade = $_POST['quantidade'];

// Converte a data para o formato correto (yyyy-mm-dd)
$diaFormatado = DateTime::createFromFormat('d/m/Y', $dia)->format('Y-m-d');

// Atualiza o dia contemplado no banco de dados
$sql = "UPDATE diacontemplado SET dia='$diaFormatado', quantidade='$quantidade' WHERE idContemplado='$idContemplado'";
$resultado = mysqli_query($conexao, $sql);

// Fecha a conexão
mysqli_close($conexao);

// Verifica se a atualização foi bem-sucedida
if ($resultado) {
    echo "<script>
        alert('Dia contemplado atualizado com sucesso!');
        window.location.href = 'inicioadm.php';
    </script>";
} else {
    echo "<script>
        alert('Erro ao atualizar o dia contemplado. Tente novamente.');
        window.history.back();
    </script>";
}
?>
