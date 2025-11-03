<!DOCTYPE html>
<html>
<head>
     <!--Import Google Icon Font-->
     <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
      <!--Let browser know website is optimized for mobile-->

    <meta charset="UTF-8">
    <title>Dia contemplados</title>
    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core/main.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid/main.css" rel="stylesheet">
    
    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/interaction/main.js"></script>


    <style>
        #calendar {
            max-width: 900px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
<?php
// Conectar ao banco de dados
include_once "headeradm.php";
require_once "conecta.php";

// Buscar os dias contemplados pela nutricionista
$sqlDias = "SELECT idContemplado, dia FROM diaContemplado";
$resultadoDias = mysqli_query($conexao, $sqlDias);

// Criar um array de datas disponíveis para o professor
$datasDisponiveis = [];
while ($linha = mysqli_fetch_assoc($resultadoDias)) {
    $datasDisponiveis[] = $linha['dia'];  // Adiciona a data ao array
}
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
<br><br> <h1 class="center-align">Cadastar novo dia contemplado</h1>
    <!-- Exibir o calendário -->
    <div id="calendar"></div>
    
    <!-- Formulário para cadastrar nova atividade -->

    <form action="cadastrodiacontemplado.php" method="post">
        <div class="card-panel ">
         <h4>Formulário</h4>

            <div class="input-field col s12">
                <input id="dataAtividade" type="text" class="datepicker" name="dataDiacontemplado" required>
                <label for="dataAtividade">Data do dia contemplado</label>
            </div>

            <!-- Campo para quantidade de refeições -->
            <div class="input-field col s12">
                <input id="quantidadeRefeicoes" type="text" class="validate" name="quantidade" pattern="^[0-9]+$" required>
                <label for="quantidadeRefeicoes">Quantidade de Refeições</label>
                <span class="helper-text" data-error="preencha utilizando apenas números."> </span>
            </div>

            <div class="row">
                <div class="col s12">
                     
                        <button class="btn waves-effect waves-light" style="background-color: #006d38;" type="submit" name="action">
                            Cadastrar
                            <i class="material-icons right">send</i> 
                        </button>
                        <a href="inicioadm.php" class="btn waves-effect waves-light red">Cancelar</a>
                   
                </div>
            </div>
        </div>
    </form>
</main>

<!-- Import jQuery and Materialize JS -->
<script type="text/javascript" src="js/materialize.min.js"></script>

<script>



    document.addEventListener('DOMContentLoaded', function() {


        // Inicializa o datepicker
        var elems = document.querySelectorAll('.datepicker');
        M.Datepicker.init(elems, {
            autoClose: true, // Fecha o date picker automaticamente após a seleção
            format: 'dd/mm/yyyy', // Define o formato da data
            yearRange: [1900, 2100], // Define o intervalo de anos
        });

        // Inicializa o calendário
        var calendarEl = document.getElementById('calendar');

        

        var calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: ['dayGrid', 'interaction'],  // Plugins do FullCalendar
            selectable: true,  // Permite selecionar os dias
     
            events: [
                <?php
                // Exibe os dias contemplados como eventos no calendário
                foreach ($datasDisponiveis as $data) {
                    echo "{ title: 'Dia Contemplado', start: '$data', color: 'green' },";
                }
                ?>
            ],
            eventClick: function(info) {
                // Quando um dia for clicado, exibe o formulário com a data preenchida
                var selectedDate = info.event.start.toISOString().split('T')[0]; // Pega a data
                document.getElementById('dataAtividade').value = selectedDate;
            }
        });

        calendar.render();
    });
</script>

</body>
</html>
