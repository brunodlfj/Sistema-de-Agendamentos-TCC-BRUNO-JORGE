<?php
session_start();

// Verifica se o usuário está logado e tem permissão de administrador
if (!isset($_SESSION['cpf']) || $_SESSION['nivel'] != 2) {
    header('Location: index.php');
    exit();
}

require_once 'conecta.php'; // Conexão com o banco de dados

// Verifica se os dados foram enviados pelo formulário
if (isset($_POST['titulo']) && isset($_POST['corpo'])) {
    // Coleta os dados do formulário
    $titulo = $_POST['titulo'];
    $corpo = $_POST['corpo'];

    // Prepara a consulta para inserir os dados na tabela 'regra'
    $sql = "INSERT INTO regra (titulo, corpo) VALUES ('$titulo', '$corpo')";

    // Executa a consulta
    if (mysqli_query($conexao, $sql)) {
        // Exibe alerta de sucesso
        echo "<script>alert('Regra adicionada com sucesso!'); window.location.href = 'regra.php';</script>";
    } else {
        // Exibe alerta de erro
        echo "<script>alert('Erro ao salvar a regra: " . mysqli_error($conexao) . "'); window.history.back();</script>";
    }
} else {
    // Se os dados não foram preenchidos corretamente
    echo "<script>alert('Preencha todos os campos.'); window.history.back();</script>";
}
?>
