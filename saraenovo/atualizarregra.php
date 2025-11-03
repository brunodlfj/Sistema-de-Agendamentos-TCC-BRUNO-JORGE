<?php
require_once "conecta.php";

if (isset($_POST['titulo']) && isset($_POST['corpo'])) {
    $titulo = trim($_POST['titulo']);
    $corpo = trim($_POST['corpo']);
    $idRegra = $_POST['idRegra'];

    // Verifica se os campos estão preenchidos
    if (empty($titulo) || empty($corpo)) {
        echo "<script>alert('Por favor, preencha todos os campos!'); window.history.back();</script>";
        exit;
    }

    // Atualiza os dados no banco de dados
    $sql = "UPDATE regra SET titulo = '$titulo', corpo = '$corpo' WHERE idRegra = $idRegra";
    if (mysqli_query($conexao, $sql)) {
        echo "<script>alert('Regra atualizada com sucesso!'); window.location.href = 'regra.php';</script>";
    } else {
        echo "<script>alert('Erro ao atualizar a regra: " . mysqli_error($conexao) . "'); window.history.back();</script>";
    }
}

mysqli_close($conexao);
?>
