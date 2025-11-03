<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Adicionar Regra - Sarae IFFAR ug</title>
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
?>

<?php
include_once "headeradm.php"; // Cabeçalho de administração

?>

<main class="container">
  <h1 class="center-align">Cadastrar Nova Regra</h1> 

  <form action="cadastroregra.php" method="POST">
  <div class="card-panel ">
    <h4> Formulário </h4>

    <!-- Campo para título -->
    <div class="input-field">
      <label for="titulo">Título da Regra</label>
      <input type="text" id="titulo" name="titulo" required>
    </div>

    <!-- Campo para corpo -->
    <div class="input-field">
      <label for="corpo">Corpo da Regra</label>
      <textarea id="corpo" name="corpo" class="materialize-textarea" required></textarea>
    </div>

    <!-- Botão de envio -->
    <button type="submit" class="btn waves-effect waves-light" style="background-color: #006d38; color: white;">
      Cadastrar  <i class="material-icons right">send</i>
    </button>
    <a href="regra.php" class="btn waves-effect waves-light red">
      Cancelar
    </a>
    </div>
  </form>
</main>

<script type="text/javascript" src="js/materialize.min.js"></script>
<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="https://www.um.es/docencia/barzana/materializecss/bin/materialize.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('select');
    var instances = M.FormSelect.init(elems);
  });
</script>

</body>
</html>
