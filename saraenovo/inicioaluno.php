<!DOCTYPE html>
<html>
<head>
<title>Sarae IFFAR ug</title>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection"/>
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <style>
        /* Ajusta o tamanho do logo */
        .logo {
            max-width: 150px; /* Ajuste o tamanho conforme necessário */
            height: auto; /* Mantém a proporção do logo */
        }

        /* Estiliza o link ativo */
        .active a {
            font-weight: bold;
            color: #00796b; 
        }

        /* Adiciona margem ao logo */
        .brand-logo img {
            display: block;
            margin: 0 auto; /* Centraliza o logo */
        }
        .tem-vagas {
            border-radius: 5px; 
            padding: 4px 8px; 
            background-color: #006d38 ; 
            color: white; 
            font-weight: bold; 
            font-size: 0.9rem; 
            margin-left: auto; 
            line-height: 1.2; 
        }
        .nao-tem-vagas {
            border-radius: 5px; 
            padding: 4px 8px; 
            background-color: #993c34; 
            color: white; 
            font-weight: bold; 
            font-size: 0.9rem; 
            margin-left: auto; 
            line-height: 1.2; 
        }
        .collapsible-header {
            display: flex;
            align-items: center;
        }
        body {
        display: flex;
        min-height: 100vh;
        flex-direction: column;
        }
        main {
        flex: 1 0 auto;
        }
        html{
            scroll-behavior: smooth;
        }
        .perguntas-collapsible .collapsible-header {
            font-weight: bold; /* Deixa o texto em negrito */
        }
        .perguntas-collapsible .collapsible-header i {
            margin-left: auto; /* Move o ícone para a extrema direita */
        }
      

        
    </style>
</head>

<link rel="shortcut icon" type=/image/png href="img/iconejanela.png" />

<body>
    <?php 
    session_start();
    if (!isset($_SESSION['cpf'])) {
        header('Location: index.php');
        exit();
    }
    $idUsuario = $_SESSION['id'];
    include_once "headeraluno.php"; 
    ?>
    <?php
include "conecta.php";

// Verifica a situação do usuário
$sqlSituacao = "SELECT situacaousuario FROM usuario WHERE id = $idUsuario";
$resultSituacao = mysqli_query($conexao, $sqlSituacao);
$situacaoUsuario = mysqli_fetch_assoc($resultSituacao)['situacaousuario'];

if ($situacaoUsuario == 1) {
    // Usuário inativo: exibe mensagem de atenção
    echo "
    <div class='container' style='margin-top: 20px;'>
        <h1 style='color: red; text-align: center;'>Atenção!</h1>
        <p style='text-align: center; font-size: 1.2rem;'>
            Discente sua conta foi temporariamente desativada no sistema pelo administrador. 
            Por favor, entre em contato com a assistência para mais informações.
        </p>
    </div>";
    exit(); // Interrompe o carregamento do restante da página
}
?>

  

<?php
// Definir o timezone
date_default_timezone_set('America/Sao_Paulo');

function dataportugues($suadata) {
    $diasSemana = [
        'Sunday' => 'Domingo',
        'Monday' => 'Segunda-feira',
        'Tuesday' => 'Terça-feira',
        'Wednesday' => 'Quarta-feira',
        'Thursday' => 'Quinta-feira',
        'Friday' => 'Sexta-feira',
        'Saturday' => 'Sábado'
    ];
    $meses = [
        'January' => 'janeiro',
        'February' => 'fevereiro',
        'March' => 'março',
        'April' => 'abril',
        'May' => 'maio',
        'June' => 'junho',
        'July' => 'julho',
        'August' => 'agosto',
        'September' => 'setembro',
        'October' => 'outubro',
        'November' => 'novembro',
        'December' => 'dezembro'
    ];
    $timestamp = strtotime($suadata);
    if (!$timestamp) {
        echo "Data inválida!";
        return;
    }
    ;
    $diaSemanaPortugues = $diasSemana[date('l', $timestamp)] ?? 'Dia desconhecido';
    $mesPortugues = $meses[date('F', $timestamp)] ?? 'Mês desconhecido';
    $ano = date('Y', $timestamp);
    $dia = date('d', $timestamp);

    // Exibir a data formatada
    echo "{$diaSemanaPortugues}, {$dia} de {$mesPortugues} de {$ano}";
}

?>
    <main>

    <div class="parallax-container">
      <div class="parallax"><img src="img/imgtelainicio.png"></div>
    </div>

        
        <div class="section white">
            <div class="row container">
                <h4 class="header" id="agendamento">Agendamento</h4>
            
            
            </div>
            <div class="row container">
                <ul class="collapsible popout" data-collapsible="accordion">
                    <?php
                    include "conecta.php"; 

                    $hora = date("H:i:s");
                    $horafim = "17:00:00";

                    
                      if($hora > $horafim) {
                      $sql = "SELECT * FROM diacontemplado WHERE dia >= CURRENT_DATE + 2 ORDER BY dia ASC LIMIT 5"; ?>
                        <div class="row">
    <div class="col s12">
      <div class="card-panel red">
        <span class="white-text"><?php echo "Agora são <b>$hora horas</b>. O agendamento para amanhã encerrou às <b>$horafim horas</b>. Caso precise de almoço, entre em contato com a Assistência."; ?>
        </span>
      </div>
    </div>
  </div>
  <?php
  }
                      else
                      $sql = "SELECT * FROM diacontemplado WHERE dia >= CURRENT_DATE + 1 ORDER BY dia ASC LIMIT 5"; 
                    
                    
                    // Conecta à base e procura hoje + 4 dias ou os próximos 5 dias
                    $resultado = mysqli_query($conexao, $sql);

                    // Para cada dia ele vai criar um acordeon
                    while ($linha = mysqli_fetch_array($resultado)) { 
                        $diadasemana = date('N', strtotime($linha['dia']))+1; // Pega o número referente ao dia ?>
                        <li>
                            <div class="collapsible-header">
                                <i class="material-icons">local_dining</i>
                                <?php echo dataportugues($linha['dia']); // Mostra o dia ?>
                               
                                <?php
                                // Ver o número de vagas disponíveis
                                $sqlconta = "SELECT COUNT(idAgendamento) AS total FROM agendamento WHERE idContemplado = $linha[idContemplado]";
                                $resultadoconta = mysqli_query($conexao, $sqlconta);
                                $total = mysqli_fetch_array($resultadoconta);
                                $total = (int) $linha['quantidade'] - (int) $total['total'];

                                // Se não tiver mais vagas, só carrega aviso disso
                                if ($total <= 0) { ?>
                                    <div class="nao-tem-vagas">
                                        0 vagas disponíveis
                                    </div>
                                </div>
                                <div class="collapsible-body"><p>
                                    Não há mais vagas para almoço nesse dia. Acompanhe o site para verificar se alguém cancelou.
                                </p></div>
                                <?php } else {  // Se tiver vagas, mostra quantas e carrega o formulário com atividades do dia ?>
                                    <div class="tem-vagas">
                                        <?php echo $total; ?> vagas disponíveis
                                    </div>
                                </div>
                                <div class="collapsible-body"><p>
    <form action="cadastroagendamento.php" method="post">
        <input type="hidden" name="idContemplado" value="<?php echo $linha['idContemplado']; ?>"> <!-- ID da data do agendamento -->
        <input type="hidden" name="id" value="<?php echo $_SESSION['id']; ?>"> <!-- ID do usuário logado -->

        <!-- Campo para escolher a atividade -->
        <?php
        $sql2 = "SELECT * FROM atividade WHERE diadasemana = $diadasemana AND situacao = 0";  // Atividades ativas
        $resultado2 = mysqli_query($conexao, $sql2);

        // Verifica se existem atividades para o dia
        $atividadesDisponiveis = mysqli_num_rows($resultado2) > 0;
        if ($atividadesDisponiveis) {
            while ($linha2 = mysqli_fetch_array($resultado2)) { ?>
                <p><label>
                    <input class="with-gap" name="idAtividade" type="radio" id="atividade_<?php echo $linha2['idAtividade']; ?>" value="<?php echo $linha2['idAtividade']; ?>" />
                    <span><?php echo $linha2['nome']; ?></span></label></p>
            <?php }
        } else {
            // Exibe mensagem se não houver atividades cadastradas
            echo "<p>Não há atividades para esse dia.</p>";
        }
        ?>

        <p class="right-align">
            <!-- Botão de agendamento desabilitado se não houver atividades -->
            <button class="btn waves-effect waves-light" style="background-color: #006d38;" 
                    type="submit" name="action" <?php echo $atividadesDisponiveis ? '' : 'disabled'; ?>>
                Agendar<i class="material-icons right">send</i>
            </button>
        </p>
    </form>
</p></div>

                                <?php }; ?>
                        </li>
                    <?php }; ?> <?php // Termina todos os acordeões (quinto se tiver) ?> 
                    
                </ul>
            </div>

            <div class="row container">
                <br> 
              <h4 class="header" id="meusAgendamentos">Meus agendamentos</h4>

            <table>
                <thead>
                    <tr>
                        
                        <th>Atividade </th>
                        <th> Dia da semana </th>
                        <th style="text-align: center;">Cancelar Agendamento</th>
                    </tr>
                </thead>
                <tbody>
    <?php
    // Ajusta o SQL para buscar o nome da atividade
    $sql = "SELECT ag.idAgendamento, ag.idAtividade, ag.idContemplado, 
                   atv.nome AS nomeAtividade, dc.dia AS diaContemplado 
            FROM agendamento ag
            JOIN atividade atv ON ag.idAtividade = atv.idAtividade
            JOIN diacontemplado dc ON ag.idContemplado = dc.idContemplado
            WHERE ag.id = $_SESSION[id]";
    
    $resultado = mysqli_query($conexao, $sql);
    while ($linha = mysqli_fetch_array($resultado)) {
        // Converte o dia da semana de número para texto
        $diaSemana = date('N', strtotime($linha['diaContemplado']));
        switch ($diaSemana) {
            case 1: $diaTexto = 'Segunda-feira'; break;
            case 2: $diaTexto = 'Terça-feira'; break;
            case 3: $diaTexto = 'Quarta-feira'; break;
            case 4: $diaTexto = 'Quinta-feira'; break;
            case 5: $diaTexto = 'Sexta-feira'; break;
            case 6: $diaTexto = 'Sábado'; break;
            case 7: $diaTexto = 'Domingo'; break;
            default: $diaTexto = 'Desconhecido'; break;
        }
    ?>
        <tr>
           
            <td><?php echo $linha['nomeAtividade']; ?></td>
            <td><?php echo $diaTexto; ?></td>
            <td style="text-align: center;">
                <a href="#modal<?php echo $linha['idAgendamento']; ?>" class="btn-floating btn-small waves-effect waves-light red modal-trigger">
                    <i class="material-icons">clear</i>
                </a>
            </td>
        </tr>

        <!-- Modal de confirmação de exclusão -->
        <div id="modal<?php echo $linha['idAgendamento']; ?>" class="modal">
                        <div class="modal-content">
                            <h4>Atenção!</h4>
                            <p>Você confirma a exclusão do agendamento da atividade <?php echo $linha['nomeAtividade']; ?>?</p>
                        </div>
                        <div class="modal-footer">
                            <form action="excluiragendamento.php" method="POST">
                                <input type="hidden" name="idAgendamento" value="<?php echo $linha['idAgendamento']; ?>">
                                <button type="submit" name="btn-deletar" class="modal-action modal-close waves-red btn red darken-1">Excluir</button>
                                <button type="button" name="btn-cancelar" class="modal-action modal-close btn waves-light green">Cancelar</button>
                            </form>
                        </div>
                    </div>
    <?php
    }
    ?>
</tbody>

            </table><br><br>
            <h4 class="header" id="perguntas" >Perguntas frequentes</h4>

            <ul class="collapsible perguntas-collapsible"> 
            <?php
            include "conecta.php";

            // Consulta todas as perguntas cadastradas
            $sql = "SELECT titulo, corpo FROM regra";
            $resultado = mysqli_query($conexao, $sql);

            // Verifica se há resultados
            if (mysqli_num_rows($resultado) > 0) {
                while ($linha = mysqli_fetch_assoc($resultado)) {
                    $titulo = $linha['titulo'];
                    $corpo = $linha['corpo'];

                    // Cria um item da lista expansível para cada registro
                    echo "
                    <li>
                        <div class='collapsible-header'>
                            $titulo
                            <i class='material-icons'>expand_more</i>
                        </div>
                        <div class='collapsible-body'><span>$corpo</span></div>
                    </li>";
                }
            } else {
                echo "<p>Nenhuma pergunta cadastrada.</p>";
            }

            // Fecha a conexão
            mysqli_close($conexao);
            ?>
        </ul>



        </div>
        
    </main>   
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('.modal');
            var instances = M.Modal.init(elems);
        });
    </script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.collapsible');
        var instances = M.Collapsible.init(elems); 
    });
</script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.parallax');
    M.Parallax.init(elems);
  });
</script>

    
    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="js/materialize.min.js"></script>
     <!--  Scripts-->
     <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="https://www.um.es/docencia/barzana/materializecss/bin/materialize.js"></script>
</body>
</html>
