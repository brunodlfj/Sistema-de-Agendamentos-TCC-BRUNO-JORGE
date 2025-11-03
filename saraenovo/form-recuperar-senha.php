<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Sarae IFFAR ug</title>
  <!-- Import Google Icon Font -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!-- Import materialize.css -->
  <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />
  <!-- Let browser know website is optimized for mobile -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" type="image/png" href="img/iconejanela.png" />
</head>

<body>

  <main class="container">
    <h1 class="center-align">Recuperação de conta</h1>


    <h6 class="center-align">Para recuperar sua conta, informe seu e-mail cadastrado.</h6>
    <p class="center-align">Será enviado para o seu e-mail um link de recuperação que você usará para criar uma nova senha!</p>

    <?php
    session_start();


    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require_once "conecta.php";

    if (isset($_POST['submit'])) {
      $email = mysqli_real_escape_string($conexao, $_POST['email']);

      // Verifica se o e-mail está cadastrado
      $sql = "SELECT * FROM usuario WHERE email='$email'";
      $resultado = mysqli_query($conexao, $sql);

      if (!$resultado) {
        echo '<div class="card-panel red lighten-4 red-text text-darken-4">Erro ao verificar o e-mail: ' . mysqli_error($conexao) . '</div>';
        exit();
      }

      $usuario = mysqli_fetch_assoc($resultado);
      if ($usuario === null) {
        // Mensagem de erro quando o e-mail não está cadastrado
        echo '<div class="card-panel red lighten-4 red-text text-darken-4">
            <h5><i class="material-icons left">error</i> E-mail não encontrado!</h5>
            <p>Por favor, insira um e-mail válido.</p>
        </div>';
        die();
      }

      // Gerar um token único 
      $token = bin2hex(random_bytes(50));

      require_once 'PHPMailer/src/PHPMailer.php';
      require_once 'PHPMailer/src/SMTP.php';
      require_once 'PHPMailer/src/Exception.php';
      include 'config.php';

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
        $mail->Subject = 'Recuperação de conta do Sistema SARAE';
        $mail->Body = 'Olá <br> 
            Você solicitou a recuperação da sua conta no nosso sistema.
            Para isso, clique no link abaixo para criar uma nova senha <br>
            <a href="' . $_SERVER['SERVER_NAME'] . '/saraenovo/nova-senha.php?email=' . $usuario['email'] .
          '&token=' . $token . '">Clique aqui para recuperar o acesso à sua conta!</a><br><br>
            Atenciosamente <br>
            Equipe Sarae';

        // Gravar informações na tabela recuperar-senha
        $data = new DateTime('now');
        $agora = $data->format('Y-m-d H:i:s');
        $sql2 = "INSERT INTO recuperar_senha (email, data_criacao, token, usado) VALUES ('" . $usuario['email'] . "', '$agora', '$token', 0)";

        if (!mysqli_query($conexao, $sql2)) {
          echo '<div class="card-panel red lighten-4 red-text text-darken-4">Erro ao registrar a solicitação de recuperação: ' . mysqli_error($conexao) . '</div>';
          exit();
        }

        $mail->send();
        echo '<div class="card-panel green lighten-4 green-text text-darken-4">
            <h5><i class="material-icons left">check_circle</i> E-mail enviado com sucesso!</h5>
            <p>Confira seu e-mail para mais instruções.</p>
        </div>';
      } catch (Exception $e) {
        echo '<div class="card-panel red lighten-4 red-text text-darken-4">
            <h5><i class="material-icons left">error</i> Não foi possível enviar o e-mail.</h5>
            <p>Erro: ' . htmlspecialchars($mail->ErrorInfo) . '</p>
        </div>';
      }
    }
    ?>

    <!-- Exibe mensagem de sucesso, se existir -->
    <?php if (isset($_SESSION['sucesso']) && !empty($_SESSION['sucesso'])): ?>
      <div class="card-panel green lighten-4">
        <p class="green-text text-darken-4"><?php echo $_SESSION['sucesso']; ?></p>
      </div>
      <?php unset($_SESSION['sucesso']); // Limpa a mensagem de sucesso após exibir 
      ?>
    <?php endif; ?>

    <form action="" method="POST">
      <div class="card-panel">
        <h4>Formulário</h4>

        <!-- Campo Email -->
        <div class="input-field col s12">
          <input type="email" id="email" name="email" class="validate" required>
          <label for="email">Informe seu email cadastrado no sistema</label>
          <span class="helper-text" data-error="Por favor, insira um e-mail válido."></span>
        </div>

        <!-- Botão de Envio -->
        <div class="row">
          <div class="col s12">
            
              <button type="submit" name="submit" class="btn waves-effect waves-light" style="background-color: #006d38;">
                Enviar e-mail
                <i class="material-icons right">send</i>
              </button>
              <a href="index.php" class="btn waves-effect waves-light red">Voltar</a>
    </form>
          </div>
        </div>
      </div>
    </form>
  </main>

  <!-- Import JavaScript -->
  <script type="text/javascript" src="js/materialize.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var elems = document.querySelectorAll('select');
      M.FormSelect.init(elems);
    });
  </script>

</body>

</html>