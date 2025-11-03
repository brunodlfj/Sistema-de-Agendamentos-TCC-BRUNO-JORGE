<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Editar Dia Contemplado</title>
    <meta charset="UTF-8">
    <!-- Import Google Icon Font -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Import Materialize CSS -->
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
    <!-- Let browser know website is optimized for mobile -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<link rel="shortcut icon" type="image/png" href="img/iconejanela.png" />
<body>
<?php
include_once "headeradm.php";
include "conecta.php";
$idContemplado = $_GET['id'];  // Recebe o ID do dia contemplado pela URL

$sql = "SELECT idContemplado, dia, quantidade FROM diacontemplado WHERE idContemplado = $idContemplado";
$resultado = mysqli_query($conexao, $sql);
$diacontemplado = mysqli_fetch_array($resultado);
?>
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
    </style>

<main class="container">
   <br><br> <h1>Editar Dia Contemplado</h1>
    <form action="atualizardiacontemplado.php" method="POST">
        <input type="hidden" name="idContemplado" value="<?php echo $diacontemplado['idContemplado']; ?>">
        
        <div class="input-field col s12">
    <input id="dia" type="text" name="dia" value="<?php echo date('d/m/Y', strtotime($diacontemplado['dia'])); ?>" readonly>
    <label for="dia" class="active">Dia Contemplado</label>
</div>
        
        <div class="input-field col s12">
    <input id="quantidadeRefeicoes" type="text" class="validate" name="quantidade" 
           pattern="^[0-9]+$" value="<?php echo $diacontemplado['quantidade']; ?>" required>
    <label for="quantidadeRefeicoes" class="active">Quantidade de Refeições</label>
    <span class="helper-text" data-error="Preencha utilizando apenas números."></span>
</div>
        
        <button type="submit" class="btn waves-effect waves-light green">Atualizar Dia Contemplado</button>
        <a href="inicioadm.php" class="btn waves-effect waves-light red">Cancelar</a>
    </form>
</main>

<!-- Import jQuery before materialize.js -->
<script type="text/javascript" src="js/materialize.min.js"></script>

</body>
</html>



