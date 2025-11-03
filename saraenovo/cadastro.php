<?php 
include 'conecta.php';
session_start();

if (isset($_POST['submit'])) {
    // Captura e sanitiza os dados do formulário
    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
    $cpf = mysqli_real_escape_string($conexao, $_POST['cpf']);
    $email = mysqli_real_escape_string($conexao, $_POST['email']);
    $senha = mysqli_real_escape_string($conexao, $_POST['senha']);
    $senha_repetir = mysqli_real_escape_string($conexao, $_POST['senha_repetir']);

    // Verifica se o CPF já está cadastrado
    $verificaCpf = "SELECT * FROM usuario WHERE cpf = '$cpf'";
    $resultadoCpf = mysqli_query($conexao, $verificaCpf);

    // Verifica se o Email já está cadastrado
    $verificaEmail = "SELECT * FROM usuario WHERE email = '$email'";
    $resultadoEmail = mysqli_query($conexao, $verificaEmail);

    // Array para armazenar mensagens de erro
    $_SESSION['erros'] = [];

    // Verifica se as senhas coincidem
    if ($senha !== $senha_repetir) {
        $_SESSION['erros'][] = "As senhas não coincidem. Por favor, repita a senha corretamente.";
    }

    // Verifica se ambos CPF e Email estão cadastrados
    if (mysqli_num_rows($resultadoCpf) > 0 && mysqli_num_rows($resultadoEmail) > 0) {
        $_SESSION['erros'][] = "Este CPF e Email já foram cadastrados. Por favor, use dados válidos ou recupere sua conta.";
    } else {
        if (mysqli_num_rows($resultadoCpf) > 0) {
            $_SESSION['erros'][] = "Este CPF já foi cadastrado. Por favor, use um CPF válido ou recupere sua conta.";
        }

        if (mysqli_num_rows($resultadoEmail) > 0) {
            $_SESSION['erros'][] = "Este Email já foi cadastrado. Por favor, use um Email válido ou recupere sua conta.";
        }
    }

    // Se houver erros, redireciona para formulario-cadastro.php
    if (!empty($_SESSION['erros'])) {
        header('Location: formulario-cadastro.php');
        exit();
    }

    // Se não houver erros, insere o usuário no banco de dados
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
    $sql = "INSERT INTO usuario (nome, cpf, email, senha, nivel) VALUES ('$nome', '$cpf', '$email', '$senhaHash', 0)";

    if (mysqli_query($conexao, $sql)) {
        // Cadastro bem-sucedido
        echo "<script>alert('Cadastro feito com sucesso! Você já pode logar no sistema.'); window.location.href = 'index.php';</script>";
        exit();
    } else {
        echo "<script>alert('Erro ao cadastrar o usuário: " . mysqli_error($conexao) . "'); window.history.back();</script>";
    }
}
?>
