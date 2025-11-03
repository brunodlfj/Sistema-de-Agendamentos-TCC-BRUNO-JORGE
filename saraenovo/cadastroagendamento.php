<?php
require_once "conecta.php";

if (isset($_POST['id']) && isset($_POST['idAtividade']) && isset($_POST['idContemplado'])) {
    $idUsuario = trim($_POST['id']);
    $idAtividade = trim($_POST['idAtividade']);
    $idContemplado = trim($_POST['idContemplado']);

    // Verifica se os campos estão preenchidos
    if (empty($idUsuario) || empty($idAtividade) || empty($idContemplado)) {
        echo "<script>alert('Por favor, selecione todas as opções do formulário!'); window.history.back();</script>";
        exit;
    }

    // Verifica se o usuário já tem um agendamento para a mesma data
    $sqlVerificaAgendamento = "SELECT * FROM agendamento WHERE id = '$idUsuario' AND idContemplado = '$idContemplado'";
    $resultadoVerifica = mysqli_query($conexao, $sqlVerificaAgendamento);

    if (mysqli_num_rows($resultadoVerifica) > 0) {
        // Usuário já tem agendamento para essa data
        echo "<script>alert('Você já possui um agendamento para essa data. Não é possível realizar outro.'); window.location.href = 'inicioaluno.php';</script>";
        exit;
    }

    // Insere os dados no banco de dados
    $sql = "INSERT INTO agendamento (id, idAtividade, idContemplado) VALUES ('$idUsuario', '$idAtividade', '$idContemplado')";
    if (mysqli_query($conexao, $sql)) {
        echo "<script>alert('Agendamento realizado com sucesso!'); window.location.href = 'inicioaluno.php';</script>";
    } else {
        echo "<script>alert('Erro ao realizar o agendamento: " . mysqli_error($conexao) . "'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Dados do formulário incompletos!'); window.history.back();</script>";
}

mysqli_close($conexao);
?>
