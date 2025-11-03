<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <!-- Import Google Icon Font -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!-- Import materialize.css -->
  <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection"/>
  <!-- Let browser know website is optimized for mobile -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body>
<?php 
include_once "headerprofessor.php";
  require_once "conecta.php";
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
  <br><br><h1 class="center-align">Cadastrar nova atividade</h1>
  <form action="cadastroatividade.php" method="post">
    <div class="card-panel">
      <h4>Formulário</h4>
      <!-- Campo Nome da Atividade -->
      <div class="input-field col s12">
        <input id="nomeAtividade" type="text" class="validate" name="nomeAtividade" pattern="[A-Za-zÀ-ÿ0-9\s]+" required>
        <label for="nomeAtividade">Nome da atividade proposta</label>
        <span class="helper-text" data-error="Preencha o campo corretamente usando somente letras e números."></span>
      </div>

      <!-- Campo Seleção do Dia da Semana -->
      <div class="input-field col s12">
        <select id="diaSemana" name="diaSemana" required > 
      <!--    <option value="" disabled selected>Selecione o dia da semana</option>-->
          
          <option value="2">Segunda-feira</option>
          <option value="3">Terça-feira</option>
          <option value="4">Quarta-feira</option>
          <option value="5">Quinta-feira</option>
          <option value="6">Sexta-feira</option>
          <option value="7">Sábado</option>
          <option value="8">Domingo</option>
        </select>
        <label for="diaSemana">Dia da Semana</label>
      </div>

    
      <div class="row">
                <div class="col s12">
                    
                        <button class="btn waves-effect waves-light" style="background-color: #006d38;" type="submit" name="action">
                            Cadastrar
                            <i class="material-icons right">send</i> 
                        </button>
                        <a href="inicioprofessor.php" class="btn waves-effect waves-light red">Cancelar</a>
                   
                </div>
            </div>
  </form>
</main>

<!-- Import JavaScript -->
<script type="text/javascript" src="js/materialize.min.js"></script>
<script>
  // Inicializar o componente select do Materialize
  document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('select');
    M.FormSelect.init(elems);
  });
</script>
</body>
</html>

      
      

  



  


 



</main>
<!--Import jQuery before materialize.js-->
<script type="text/javascript" src="js/materialize.min.js"></script>

<script>
        // Inicializa o date picker
        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('.datepicker');
            M.Datepicker.init(elems, {
                autoClose: true, // Fecha o date picker automaticamente após a seleção
                format: 'dd/mm/yyyy', // Define o formato da data
                yearRange: [1900, 2100], // Define o intervalo de anos
                
                
                onSelect: function(date) {
                    console.log('Data selecionada: ', date);
                }
            });
        }); 


        

      document.addEventListener('DOMContentLoaded', function() 
        {
        var elems = document.querySelectorAll('select');
        var instances = M.FormSelect.init(elems);
      });


</script>


</body>
</html>