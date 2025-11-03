<?php
include 'conecta.php';
session_start();

if (isset($_POST['submit']) && !empty($_POST['cpf']) && !empty($_POST['senha'])) {
    $cpf = mysqli_real_escape_string($conexao, $_POST['cpf']);
    $senha = $_POST['senha'];

    // Consulta para verificar o usuário
    $sql = "SELECT * FROM usuario WHERE cpf = '$cpf'";
    $resultado = mysqli_query($conexao, $sql);

    if (mysqli_num_rows($resultado) > 0) {
        $usuario = mysqli_fetch_assoc($resultado);
        
        // Verifica a senha
        if (password_verify($senha, $usuario['senha'])) {
            // Define as variáveis de sessão
            $_SESSION['cpf'] = $usuario['cpf'];
            $_SESSION['nivel'] = $usuario['nivel'];
            $_SESSION['id'] = $usuario['id'];  // Sempre defina o ID aqui

            // Redireciona com base no nível do usuário
            if ($usuario['nivel'] == 0) {
                header('Location: inicioaluno.php');
            } elseif ($usuario['nivel'] == 1) {
                header('Location: inicioprofessor.php');
            } elseif ($usuario['nivel'] == 2) {
                header('Location: inicioadm.php');
            } else {
                header('Location: index.php');
            }
            exit();
        } else {
            // Senha incorreta
            $_SESSION['erro'] = 'Senha incorreta!';
            header('Location: index.php');
            exit();
        }
    } else {
        // Usuário não encontrado
        $_SESSION['erro'] = 'Usuário não encontrado!';
        header('Location: index.php');
        exit();
    }
}

?>
