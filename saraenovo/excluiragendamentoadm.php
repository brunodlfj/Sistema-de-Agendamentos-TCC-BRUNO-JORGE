<?php
include "conecta.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once "PHPMailer/src/PHPMailer.php";
require_once "PHPMailer/src/SMTP.php";
require_once "PHPMailer/src/Exception.php";

// Pega o idAgendamento do POST
$idAgendamento = $_POST['idAgendamento'];

// Consulta para pegar o e-mail do usuário
$sqlUsuario = "SELECT u.email, u.nome FROM usuario u
               JOIN agendamento a ON a.id = u.id
               WHERE a.idAgendamento = $idAgendamento";
$resultadoUsuario = mysqli_query($conexao, $sqlUsuario);
$usuario = mysqli_fetch_assoc($resultadoUsuario);

// Exclui o agendamento
$sql = "DELETE FROM agendamento WHERE idAgendamento = $idAgendamento";
$resultado = mysqli_query($conexao, $sql);

// Fecha a conexão
mysqli_close($conexao);

// Se o agendamento foi excluído com sucesso
if ($resultado) {
    // Envia o e-mail de confirmação para o usuário
    require_once 'config.php';

    $mail = new PHPMailer(true);
    try {
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';
        $mail->setLanguage('br');
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $config['email'];
        $mail->Password = $config['senha_email'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        // Recipients
        $mail->setFrom($config['email'], 'SARAE');
        $mail->addAddress($usuario['email'], $usuario['nome']);
        $mail->addReplyTo($config['email'], 'SARAE');

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Exclusão de agendamento - Sistema SARAE';
        $mail->Body = 'Olá ' . $usuario['nome'] . ',<br>
            Informamos que o seu agendamento foi excluído pelo administrador do sistema SARAE.<br><br>
            Acesse novamente o site para agendar para um novo dia ou compareça na assitência para maiores esclarecimentos!<br><br>
            Atenciosamente,<br>
            Equipe SARAE';

        $mail->send();
        
        // Alerta o administrador que o agendamento foi excluído
        echo "<script>
                alert('Agendamento excluído com sucesso e e-mail enviado ao usuário!');
                window.location.href = 'visualizardiacontemplado.php';
              </script>";

    } catch (Exception $e) {
        echo '<script>
                alert("Erro ao excluir o agendamento e/ou enviar o e-mail. Erro: ' . htmlspecialchars($mail->ErrorInfo) . '");
                window.location.href = "visualizardiacontemplado.php";
              </script>';
    }

} else {
    echo "<script>
            alert('Erro ao excluir o agendamento.');
            window.location.href = 'visualizardiacontemplado.php';
          </script>";
}
?>
