<!DOCTYPE html>
<html>
<head>
    <title>Editar Atividade</title>
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
include "conecta.php";
$idAtividade = $_GET['id']; // Recebe o ID da atividade pela URL

$sql = "SELECT idAtividade, nome, diadasemana, situacao FROM atividade WHERE idAtividade = $idAtividade";
$resultado = mysqli_query($conexao, $sql);
$atividade = mysqli_fetch_array($resultado);

// Array de dias da semana para exibição
$diasSemana = [
    1 => "Domingo",
    2 => "Segunda-feira",
    3 => "Terça-feira",
    4 => "Quarta-feira",
    5 => "Quinta-feira",
    6 => "Sexta-feira",
    0 => "Sábado"
];
?>
<main class="container">
    <h1>Editar Atividade</h1>
    <form action="atualizaratividade.php" method="POST">
        <input type="hidden" name="idAtividade" value="<?php echo $atividade['idAtividade']; ?>">

        <div class="input-field col s12">
            <input 
                id="nome" 
                type="text" 
                name="nome" 
                pattern="[A-Za-zÀ-ÿ0-9\s]+" 
                value="<?php echo $atividade['nome']; ?>" 
                class="validate" 
                required>
            <label for="nome">Atividade</label>
            <span class="helper-text" data-error="Preencha utilizando apenas letras e números." data-success="Parece bom!"></span>
        </div>

        <div class="input-field col s12">
        <select id="diaSemana" name="diadasemana" required > 
      <!--    <option value="" disabled selected>Selecione o dia da semana</option>-->
          
          <option value="2">Segunda-feira</option>
          <option value="3">Terça-feira</option>
          <option value="4">Quarta-feira</option>
          <option value="5">Quinta-feira</option>
          <option value="6">Sexta-feira</option>
          <option value="0">Sábado</option>
          <option value="1">Domingo</option>
        </select>
        <label for="diaSemana">Dia da Semana</label>
      </div>

        <div class="input-field col s12">
            <select id="situacao" name="situacao" required>
                <option value="0" <?php echo $atividade['situacao'] == 0 ? 'selected' : ''; ?>>Ativo</option>
                <option value="1" <?php echo $atividade['situacao'] == 1 ? 'selected' : ''; ?>>Inativo</option>
            </select>
            <label for="situacao">Situação</label>
        </div>

        <button type="submit" class="btn waves-effect waves-light green">Atualizar Atividade</button>
        <a href="inicioprofessor.php" class="btn waves-effect waves-light red">Cancelar</a>
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
