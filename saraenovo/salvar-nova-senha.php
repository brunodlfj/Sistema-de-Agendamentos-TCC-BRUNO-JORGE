<?php 
require_once "conecta.php"; // Incluindo a conexão

session_start(); // Inicia a sessão para armazenar as mensagens

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $token = $_POST['token'];
    $senha = $_POST['senha'];
    $repetirSenha = $_POST['repetirSenha'];

    // Conexão com o banco de dados
    $conexao = mysqli_connect($bdServidor, $bdUsuario, $bdSenha, $bdBanco);

    // Verificação do e-mail e token
    $sql = "SELECT * FROM recuperar_senha WHERE email = '$email' AND token = '$token'";
    $resultado = mysqli_query($conexao, $sql);
    $recuperar = mysqli_fetch_assoc($resultado);

    if (!$recuperar) {
        $_SESSION['erros'][] = "E-mail ou token incorretos. Tente fazer um novo pedido de recuperação de senha.";
    } else {
        // Verificar a validade do pedido
        date_default_timezone_set('America/Sao_Paulo');
        $agora = new DateTime('now');
        $data_criacao = DateTime::createFromFormat('Y-m-d H:i:s', $recuperar['data_criacao']);
        $umDia = DateInterval::createFromDateString('1 day');
        $data_expiracao = date_add($data_criacao, $umDia);

        if ($agora > $data_expiracao) {
            $_SESSION['erros'][] = "Essa solicitação de recuperação de senha expirou!";
        } elseif ($recuperar['usado'] == 1) {
            $_SESSION['erros'][] = "Esse pedido de recuperação de senha já foi utilizado anteriormente!";
        } elseif ($senha != $repetirSenha) {
            $_SESSION['erros'][] = "As senhas não coincidem! Por favor, tente novamente.";
        } else {
            // Atualiza a senha no banco
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
            $sql2 = "UPDATE usuario SET senha = '$senhaHash' WHERE email='$email'";
            mysqli_query($conexao, $sql2);
            $sql3 = "UPDATE recuperar_senha SET usado = 1 WHERE email = '$email' AND token='$token'";
            mysqli_query($conexao, $sql3);

            $_SESSION['sucesso'] = "Nova senha cadastrada com sucesso!";
            header("Location: index.php");
            exit();
        }
    }
    // Redireciona de volta para nova-senha.php caso ocorra erro
    header("Location: nova-senha.php?email=" . $email .
          "&token=" . $token);


    
    exit();
} else {
    $_SESSION['erros'][] = "Acesso inválido. Por favor, envie o formulário.";
    header("Location: nova-senha.php");
    exit();
}
?>
