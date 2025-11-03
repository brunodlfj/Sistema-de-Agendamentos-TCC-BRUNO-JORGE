<?php
require_once "conecta.php"; // Incluindo a conexão

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id']; // ID do usuário
    $email = $_POST['email']; // Novo email
    $senha = $_POST['senha']; // Nova senha
    $repetirSenha = $_POST['repetirSenha']; // Confirmação da senha

    // Valida se as senhas coincidem
    if ($senha !== $repetirSenha) {
        echo "<script>
            alert('As senhas não coincidem! Por favor, tente novamente.');
            window.location.href = 'perfil.php?id=$id';
        </script>";
        exit();
    }

    // Criptografa a nova senha
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    // Atualiza o email e a senha no banco de dados
    $sql = "UPDATE usuario SET email = '$email', senha = '$senhaHash' WHERE id = $id";
    $resultado = mysqli_query($conexao, $sql);

    // Verifica se a atualização foi bem-sucedida
    if ($resultado) {
        echo "<script>
            alert('Perfil atualizado com sucesso!');
            window.location.href = 'perfil.php?id=$id';
        </script>";
    } else {
        echo "<script>
            alert('Erro ao atualizar o perfil. Por favor, tente novamente.');
            window.location.href = 'perfil.php?id=$id';
        </script>";
    }

    exit();
} else {
    // Caso o acesso seja direto ao arquivo
    echo "<script>
        alert('Acesso inválido. Por favor, envie o formulário.');
        window.location.href = 'perfil.php';
    </script>";
    exit();
}
?>
