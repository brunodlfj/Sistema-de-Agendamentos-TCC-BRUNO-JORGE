<!DOCTYPE html>
<html>

<head>
  <title>Sarae IFFAR ug</title>
  <!--Import Google Icon Font-->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!--Import materialize.css-->
  <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />
  <!--Let browser know website is optimized for mobile-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

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
</head>

<link rel="shortcut icon" type="image/png" href="img/iconejanela.png" />

<body>
  <?php
  session_start();
  if (!isset($_SESSION['cpf']) || $_SESSION['nivel'] != 2) {
    header('Location: index.php');
    exit();
  }
  $idUsuario = $_SESSION['id'];
  ?>
  <?php
  include "conecta.php";
  include_once "headeradm.php";

  // Verifica a situação do usuário
  $sqlSituacao = "SELECT situacaousuario FROM usuario WHERE id = $idUsuario";
  $resultSituacao = mysqli_query($conexao, $sqlSituacao);
  $situacaoUsuario = mysqli_fetch_assoc($resultSituacao)['situacaousuario'];

  if ($situacaoUsuario == 1) {
    // Usuário inativo: exibe mensagem de atenção
    echo "
    <div class='container' style='margin-top: 20px;'>
      <br>  <h1 style='color: red; text-align: center;'>Atenção!</h1>
        <p style='text-align: center; font-size: 1.2rem;'>
            Administrador sua conta foi temporariamente desativada no sistema pelo administrador. 
            Por favor, entre em contato com a assistência para mais informações.
        </p>
    </div>";
    exit(); // Interrompe o carregamento do restante da página
  }
  ?>

  <?php
  include_once "headeradm.php";
  require_once 'conecta.php';
  ?>

  <div class="parallax-container">
    <div class="parallax"><img src="img/imgtelainicio.png"></div>
  </div>
  <main class="container">
    
    <h4 class="header" id="proximosalmocos">Próximos almoços</h4><br>
    <a class="waves-effect waves-light btn" href="formulariodiacontemplado.php" style="background-color: #006d38; color: white;">
      <i class="material-icons left">add</i>Adicionar dia contemplado
    </a>
    <table>
      <thead>
        <tr>
          <th>Dia </th>
          <th>Refeições</th>
          <th>Agendados</th>
          <th>Visualizar</th>
          <th>Editar</th>
          <th>Excluir</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $hoje = date('Y-m-d');
        $sql = "SELECT idContemplado, dia, quantidade FROM diacontemplado WHERE dia >= '$hoje' ORDER BY dia ASC";
        $resultado = mysqli_query($conexao, $sql);
        while ($linha = mysqli_fetch_array($resultado)) {
            // Consultando o número de agendamentos para este idContemplado
            $idContemplado = $linha['idContemplado'];
            $sqlAgendados = "SELECT COUNT(*) as agendados FROM agendamento WHERE idContemplado = $idContemplado";
            $resultadoAgendados = mysqli_query($conexao, $sqlAgendados);
            $agendados = mysqli_fetch_assoc($resultadoAgendados)['agendados'];
        ?>
          <tr>
            <td><?php echo date('d/m/Y', strtotime($linha['dia'])); ?></td>
            <td><?php echo $linha['quantidade']; ?></td>
            <td><?php echo $agendados; ?></td>
            <td>
              <a href="visualizardiacontemplado.php?id=<?php echo $linha['idContemplado']; ?>" class="btn-floating btn-small waves-effect waves-light blue">
                <i class="material-icons">visibility</i>
              </a>
            </td>
            <td>
              <a href="editardiacontemplado.php?id=<?php echo $linha['idContemplado']; ?>" class="btn-floating btn-small waves-effect waves-light green">
                <i class="material-icons">edit</i>
              </a>
            </td>
            <td>
              <a href="#modal<?php echo $linha['idContemplado']; ?>" class="btn-floating btn-small waves-effect waves-light red modal-trigger">
                <i class="material-icons">delete</i>
              </a>
            </td>
            <div id="modal<?php echo $linha['idContemplado']; ?>" class="modal">
              <div class="modal-content">
                <h4>Atenção!</h4>
                <p>Você confirma a exclusão do dia contemplado <?php echo date('d/m/Y', strtotime($linha['dia'])); ?>?</p>
              </div>
              <div class="modal-footer">
                <form action="excluirdiacontemplado.php" method="POST">
                  <input type="hidden" name="idContemplado" value="<?php echo $linha['idContemplado']; ?>">
                  <button type="submit" name="btn-deletar" class="modal-action modal-close waves-red btn red darken-1">Excluir</button>
                  <button type="button" name="btn-cancelar" class="modal-action modal-close btn waves-light green">Cancelar</button>
                </form>
              </div>
            </div>
          </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
    <br><br><br>

    <h4 class="header" id="almocosanteriores">Almoços anteriores</h4>
    <table>
      <thead>
        <tr>
          <th>Dia </th>
          <th>Refeições</th>
          <th>Agendados</th>
          <th>Visualizar</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT idContemplado, dia, quantidade FROM diacontemplado WHERE dia < '$hoje' ORDER BY dia DESC";
        $resultado = mysqli_query($conexao, $sql);
        while ($linha = mysqli_fetch_array($resultado)) {
            // Consultando o número de agendamentos para este idContemplado
            $idContemplado = $linha['idContemplado'];
            $sqlAgendados = "SELECT COUNT(*) as agendados FROM agendamento WHERE idContemplado = $idContemplado";
            $resultadoAgendados = mysqli_query($conexao, $sqlAgendados);
            $agendados = mysqli_fetch_assoc($resultadoAgendados)['agendados'];
        ?>
          <tr>
            <td><?php echo date('d/m/Y', strtotime($linha['dia'])); ?></td>
            <td><?php echo $linha['quantidade']; ?></td>
            <td><?php echo $agendados; ?></td>
            <td>
              <a href="visualizardiacontemplado.php?id=<?php echo $linha['idContemplado']; ?>" class="btn-floating btn-small waves-effect waves-light blue">
                <i class="material-icons">visibility</i>
              </a>
            </td>
          </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
  </main>

  <script type="text/javascript" src="js/materialize.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var elems = document.querySelectorAll('.modal');
      M.Modal.init(elems);
    });
  </script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var elems = document.querySelectorAll('.parallax');
      M.Parallax.init(elems);
    });
  </script>
</body>

</html>
