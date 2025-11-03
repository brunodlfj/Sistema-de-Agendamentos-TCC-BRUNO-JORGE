<!DOCTYPE html>
<html>
<head>
    <title>Editar Regra</title>
    <meta charset="UTF-8">
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Import Materialize CSS -->
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />
    <!-- Let browser know website is optimized for mobile -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
<link rel="shortcut icon" type="image/png" href="img/iconejanela.png" />
<body>
<?php
include_once "headeradm.php";
include "conecta.php";
$idRegra = $_GET['id']; // Recebe o ID da atividade pela URL

$sql = "SELECT idRegra, titulo, corpo FROM regra WHERE idRegra = $idRegra";
$resultado = mysqli_query($conexao, $sql);
$regra = mysqli_fetch_array($resultado);

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
    <br><br><h1>Editar Regra</h1>
    <form action="atualizarregra.php" method="POST">
        <input type="hidden" name="idRegra" value="<?php echo $regra['idRegra']; ?>">

        <div class="input-field col s12">
            <input 
                id="titulo" 
                type="text" 
                name="titulo" 
              
                value="<?php echo $regra['titulo']; ?>" 
                class="validate" 
                required>
            <label for="titulo">Titulo</label>
            <span class="helper-text" data-error="Preencha utilizando apenas letras e números." data-success="Parece bom!"></span>
        </div>

        <div class="input-field col s12">
            <input 
                id="corpo" 
                type="text" 
                name="corpo"  
                pattern="^[a-zA-Z0-9À-ÖØ-öø-ÿ.,!?;:'()\[\]{}\-_/\\@#&*+=%$|<>\s]+$"
                value="<?php echo $regra['corpo']; ?>" 
                class="validate" 
                required>
            <label for="corpo">Corpo</label>
            <span class="helper-text" data-error="Preencha utilizando apenas letras e números." data-success="Parece bom!"></span>
        </div>

      

    
        <button type="submit" class="btn waves-effect waves-light green">Atualizar Regra</button>
        <a href="regra.php" class="btn waves-effect waves-light red">Cancelar</a>
    </form>
</main>

<!-- Import jQuery before materialize.js -->
<script type="text/javascript" src="js/materialize.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var elems = document.querySelectorAll('select');
        M.FormSelect.init(elems);
    });
</script>
</body>
</html>
