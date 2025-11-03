<?php
require_once "conecta.php";

if (isset($_POST['dataDiacontemplado']) && isset($_POST['quantidade'])) {
    $dataDiaContemplado = trim($_POST['dataDiacontemplado']);
    $quantidade = trim($_POST['quantidade']);

    if (empty($dataDiaContemplado) || empty($quantidade)) {
        echo "<script>alert('Por favor, preencha todos os campos!'); window.history.back();</script>";
        exit;
    }

    // Validar a data
    $dataDiaContempladoFormatada = DateTime::createFromFormat('d/m/Y', $dataDiaContemplado);
    if (!$dataDiaContempladoFormatada) {
        echo "<script>alert('Data inválida! Use o formato DD/MM/AAAA.'); window.history.back();</script>";
        exit;
    }
    $dataDiaContempladoFormatada = $dataDiaContempladoFormatada->format('Y-m-d');

    // Verificar se a data já existe no banco
    $sql_verifica = "SELECT COUNT(*) AS total FROM diaContemplado WHERE dia = '$dataDiaContempladoFormatada'";
    $resultado_verifica = mysqli_query($conexao, $sql_verifica);
    $linha_verifica = mysqli_fetch_assoc($resultado_verifica);

    if ($linha_verifica['total'] > 0) {
        echo "<script>alert('Esta data já está cadastrada no sistema!'); window.history.back();</script>";
        exit;
    }

    // Inserir os dados no banco de dados
    $sql = "INSERT INTO diaContemplado (dia, quantidade) VALUES ('$dataDiaContempladoFormatada', '$quantidade')";
    if (mysqli_query($conexao, $sql)) {
        echo "<script>alert('Dia contemplado cadastrado com sucesso!'); window.location.href = 'inicioadm.php';</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar dia contemplado: " . mysqli_error($conexao) . "'); window.history.back();</script>";
    }
}

mysqli_close($conexao);
?>
