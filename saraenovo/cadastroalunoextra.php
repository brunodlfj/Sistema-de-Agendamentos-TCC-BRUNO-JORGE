<?php
include "conecta.php";

// Verifica se os usuários foram selecionados e o ID do dia contemplado está disponível
if (isset($_POST['usuarios']) && !empty($_POST['usuarios']) && isset($_GET['id'])) {
    $usuarios = $_POST['usuarios']; // IDs dos usuários selecionados
    $idContemplado = $_GET['id']; // Recebe o idContemplado via GET

    // Loop para inserir os alunos selecionados na tabela de agendamento
    foreach ($usuarios as $usuarioId) {
        // Verifica se o agendamento já existe para o usuário e o dia contemplado
        $checkSql = "SELECT * FROM agendamento WHERE id = '$usuarioId' AND idContemplado = '$idContemplado'";
        $checkResult = mysqli_query($conexao, $checkSql);
        
        if (mysqli_num_rows($checkResult) == 0) {
            // Caso o agendamento não exista, insere o novo agendamento
            $sql = "INSERT INTO agendamento (id, idContemplado) VALUES ('$usuarioId', '$idContemplado')";
            if (mysqli_query($conexao, $sql)) {
                echo "<script>alert('Agendamento extra realizado com sucesso!'); window.location.href = 'visualizardiacontemplado.php?id=$idContemplado';</script>";
            } else {
                echo "<script>alert('Erro ao realizar o agendamento: " . mysqli_error($conexao) . "'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('Usuário já agendado para este dia!'); window.history.back();</script>";
        }
    }

} else {
    echo "<script>alert('Nenhum usuário selecionado ou ID do dia contemplado não encontrado.'); window.history.back();</script>";
}
?>
