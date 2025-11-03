<?php
session_start();
if (!isset($_SESSION['cpf']) || $_SESSION['nivel'] != 2) {
    header('Location: index.php');
    exit();
}

include_once "headeradm.php";
require_once 'conecta.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once "PHPMailer/src/PHPMailer.php";
require_once "PHPMailer/src/SMTP.php";
require_once "PHPMailer/src/Exception.php";

// Verifica se o parâmetro 'id' foi passado na URL
if (!isset($_GET['id'])) {
    die("ID do dia contemplado não especificado.");
}

$idContemplado = $_GET['id'];

// Inicializa a variável $resultado
$resultado = null;

// Consultando a data do dia contemplado
$sqlData = "SELECT dia FROM diacontemplado WHERE idContemplado = '$idContemplado'";
$resultadoData = mysqli_query($conexao, $sqlData);
$dataContemplado = null;
if ($resultadoData && mysqli_num_rows($resultadoData) > 0) {
    $linhaData = mysqli_fetch_array($resultadoData);
    $dataContemplado = $linhaData['dia'];  // Data no formato Y-m-d
}

// Formata a data para o formato desejado: "Dia da semana, número do mês de mês do ano"
if ($dataContemplado) {
    $dataFormatada = date('l, d \d\e F \d\e Y', strtotime($dataContemplado));
    // Traduz para português
    $diasSemana = [
        "Sunday" => "Domingo", "Monday" => "Segunda-feira", "Tuesday" => "Terça-feira", 
        "Wednesday" => "Quarta-feira", "Thursday" => "Quinta-feira", "Friday" => "Sexta-feira", 
        "Saturday" => "Sábado"
    ];
    $meses = [
        "January" => "janeiro", "February" => "fevereiro", "March" => "março", "April" => "abril",
        "May" => "maio", "June" => "junho", "July" => "julho", "August" => "agosto", 
        "September" => "setembro", "October" => "outubro", "November" => "novembro", "December" => "dezembro"
    ];
    $dataFormatada = str_replace(array_keys($diasSemana), array_values($diasSemana), $dataFormatada);
    $dataFormatada = str_replace(array_keys($meses), array_values($meses), $dataFormatada);
}

// Verifica se o formulário foi enviado para salvar as presenças
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['salvarPresenca'])) {
        // Atualiza a presença para todos os agendamentos
        $sucesso = true;  // Flag para verificar se tudo foi atualizado corretamente

        // Primeiro, atualizar todos os agendamentos como 0 (falta)
        $sqlAtualizarTodos = "UPDATE agendamento SET presencaAlmoco = 0 WHERE idContemplado = '$idContemplado'";
        if (!mysqli_query($conexao, $sqlAtualizarTodos)) {
            $sucesso = false;
        }

        // Verifica se o campo 'presenca' está presente no POST
        if (isset($_POST['presenca']) && is_array($_POST['presenca'])) {
            // Atualiza a presença para os checkboxes marcados
            foreach ($_POST['presenca'] as $idAgendamento) {
                // Atualiza a coluna presencaAlmoco para 1 (presente) no agendamento correspondente
                $sqlAtualizarPresenca = "UPDATE agendamento SET presencaAlmoco = 1 WHERE idAgendamento = '$idAgendamento'";
                if (!mysqli_query($conexao, $sqlAtualizarPresenca)) {
                    $sucesso = false;
                }
            }
        }

        // Mensagem de sucesso ou erro
        if ($sucesso) {
            echo "<script>alert('Presenças registradas com sucesso!');</script>";
        } else {
            echo "<script>alert('Houve um erro ao salvar as presenças.');</script>";
        }
    }

    // Exclusão de agendamento
    if (isset($_POST['excluirAgendamento'])) {
        $idAgendamento = $_POST['idAgendamento'];

        // Consulta para pegar o e-mail do usuário
        $sqlUsuario = "SELECT u.email, u.nome FROM usuario u
                       JOIN agendamento a ON a.id = u.id
                       WHERE a.idAgendamento = $idAgendamento";
        $resultadoUsuario = mysqli_query($conexao, $sqlUsuario);
        $usuario = mysqli_fetch_assoc($resultadoUsuario);

        // Exclui o agendamento
        $sqlExcluir = "DELETE FROM agendamento WHERE idAgendamento = '$idAgendamento'";
        if (mysqli_query($conexao, $sqlExcluir)) {
            // Envio do e-mail de confirmação
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
                    Informamos que um agendamento seu foi excluído pelo administrador do sistema SARAE.<br><br>
                    Acesse novamente o site para verificar e agendar outra refeição. <br>
                    Você também pode comparecer na assistência para maiores esclarecimentos!<br><br>
                    Atenciosamente,<br>
                    Equipe SARAE';

                $mail->send();

                // Alerta o administrador que o agendamento foi excluído
                echo "<script>
        alert('Agendamento excluído com sucesso e e-mail enviado ao usuário!');
        window.location.href = 'visualizardiacontemplado.php?id=$idContemplado';
      </script>";
            } catch (Exception $e) {
                echo '<script>
                        alert("Erro ao excluir o agendamento e/ou enviar o e-mail. Erro: ' . htmlspecialchars($mail->ErrorInfo) . '");
                        window.location.href = "visualizardiacontemplado.php";
                      </script>';
            }

        } else {
            echo "<script>
                    alert('Erro ao excluir agendamento.');
                    window.location.href = 'visualizardiacontemplado.php';
                  </script>";
        }
    }
}

// Reexecuta a consulta para garantir que os dados mais recentes sejam exibidos
$sql = "SELECT ag.idAgendamento, u.nome AS usuario, u.cpf, a.nome AS atividade, ag.presencaAlmoco
        FROM agendamento ag
        LEFT JOIN usuario u ON ag.id = u.id
        LEFT JOIN atividade a ON ag.idAtividade = a.idAtividade
        WHERE ag.idContemplado = '$idContemplado'";

$resultado = mysqli_query($conexao, $sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Agendamentos - Dia Contemplado</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />
    <link rel="shortcut icon" type="image/png" href="img/iconejanela.png" />
</head>
<body>
<style>
    .logo {
      max-width: 150px;
      height: auto;
    }

    .active a {
      font-weight: bold;
      color: #00796b;
    }

    .brand-logo img {
      display: block;
      margin: 0 auto;
    }

    /* Centraliza o conteúdo e os títulos das tabelas */
    table thead th,
    table tbody td {
      text-align: center;
    }
  

</style>
<main class="container">
    <h1>Visualização</h1> 
    <h5>Agendamentos para <?php echo $dataFormatada; ?>.</h5> <br> <br>

<a class="waves-effect waves-light btn" href="formularioadicionaraluno.php?id=<?php echo $idContemplado; ?>" style="background-color: #006d38; color: white;">
    <i class="material-icons left">add</i>Adicionar aluno
</a><br> <br>

    <!-- Formulário para registrar presença -->
    <form method="POST">
    <table>
    <thead>
        <tr>
            <th>Usuário</th>
            <th>CPF</th>
            <th>Atividade</th>
            <th class="center-align">Presença</th>
            <th class="center-align">Cancelar Agendamento</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (mysqli_num_rows($resultado) > 0) {
            // Exibe os agendamentos encontrados
            while ($linha = mysqli_fetch_array($resultado)) {
                // Verifica se idAtividade é nulo
                if (is_null($linha['atividade'])) {
                    $atividade = "Aluno extra agendado"; // Mensagem caso a atividade seja nula
                } else {
                    $atividade = $linha['atividade']; // Caso contrário, exibe a atividade normal
                }

                // Marca a presença como checkbox, com valor 1 para presente
                $checked = ($linha['presencaAlmoco'] == 1) ? "checked" : "";
                echo "<tr>";
                echo "<td>" . $linha['usuario'] . "</td>";
                echo "<td>" . $linha['cpf'] . "</td>";
                echo "<td>" . $atividade . "</td>";
                echo "<td class='center-align'><label><input type='checkbox' name='presenca[]' value='" . $linha['idAgendamento'] . "' " . $checked . "><span></span></label></td>";
                echo "<td class='center-align'>
                        <form method='POST' action='visualizardiacontemplado.php'>
                            <input type='hidden' name='idAgendamento' value='" . $linha['idAgendamento'] . "' />
                            <button class='btn-floating btn waves-effect waves-light red' name='excluirAgendamento'>
                                <i class='material-icons'>delete</i>
                            </button>
                        </form>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Não há agendamentos para este dia.</td></tr>";
        }
        ?>
    </tbody>
</table>

    <br>
    <button type="submit" name="salvarPresenca" class="waves-effect waves-light btn" style="background-color: #006d38; color: white;">
    <i class="material-icons right">done </i>Salvar Presença
</button>
        <a href="inicioadm.php" class="btn waves-effect waves-light red">Voltar</a>
    </form>
</main>
</body>
</html>
