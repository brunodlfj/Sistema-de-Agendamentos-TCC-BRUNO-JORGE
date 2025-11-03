<?php
require_once "conecta.php";

if (isset($_POST['nomeAtividade']) && isset($_POST['diaSemana'])) {
    $nomeAtividade = trim($_POST['nomeAtividade']);
    $diaSemana = trim($_POST['diaSemana']);

    session_start();
    $id = $_SESSION['id'];

    // Verifica se os campos estão preenchidos
    if (empty($nomeAtividade) || $diaSemana === "") {
        echo "<script>alert('Por favor, preencha todos os campos!'); window.history.back();</script>";
        exit;
    }

    // Validação do dia da semana
    if (!is_numeric($diaSemana) || $diaSemana < 0 || $diaSemana > 6) {
        echo "<script>alert('Dia da semana inválido!'); window.history.back();</script>";
        exit;
    }

    // Insere os dados no banco de dados
    $sql = "INSERT INTO atividade (nome, diadasemana, id) VALUES ('$nomeAtividade', '$diaSemana', '$id')";
    if (mysqli_query($conexao, $sql)) {
        echo "<script>alert('Atividade cadastrada com sucesso!'); window.location.href = 'inicioprofessor.php';</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar atividade: " . mysqli_error($conexao) . "'); window.history.back();</script>";
    }
}

mysqli_close($conexao);
?>
