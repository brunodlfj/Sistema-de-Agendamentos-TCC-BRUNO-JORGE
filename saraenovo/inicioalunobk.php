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
            background-color: #26a69a; 
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
    include_once "headeraluno.php"; 
    ?>
    <main>
        
        <div class="section white">
    <div class="row container">
    <h1> Home aluno</h1>
      <h4 class="header">Agendamento</h4>
      <p class="grey-text text-darken-3 lighten-3">Tá querendo almoçar? Então vê se marca almoço.</p>
    </div>
    <div class="row container">
        <ul class="collapsible popout" data-collapsible="accordion">
            <li>
                <div class="collapsible-header active">
                    <i class="material-icons">local_dining</i>
                    Segunda-Feira, 16 de outubro de 2024
                    <div class="tem-vagas">
                        5 vagas disponíveis
                    </div>
                </div>
                <div class="collapsible-body">
                    <form action="#">
                        <p>
                          <input name="group1" type="radio" id="test1" />
                          <label for="test1">Red</label>
                        </p>
                        <p>
                          <input name="group1" type="radio" id="test2" />
                          <label for="test2">Yellow</label>
                        </p>
                        <p>
                          <input class="with-gap" name="group1" type="radio" id="test3"  />
                          <label for="test3">Green</label>
                        </p>
                          <p>
                            <input name="group1" type="radio" id="test4" disabled="disabled" />
                            <label for="test4">Brown</label>
                        </p>
                      </form>
                </div>
            </li>
            <li>
                <div class="collapsible-header">
                    <i class="material-icons">local_dining</i>
                    Terça-Feira, 17 de outubro de 2024
                    <div class="nao-tem-vagas">
                        0 vagas disponíveis
                    </div>
                </div>
                <div class="collapsible-body"><p>Lorem ipsum dolor sit amet.</p></div>
            </li>
            <li>
                <div class="collapsible-header">
                    <i class="material-icons">local_dining</i>
                    Quarta-Feira, 18 de outubro de 2024
                    <div class="tem-vagas">
                        8 vagas disponíveis
                    </div>
                </div>
                <div class="collapsible-body"><p>Lorem ipsum dolor sit amet.</p></div>
            </li>
            <li>
                <div class="collapsible-header">
                    <i class="material-icons">local_dining</i>
                    Quinta-Feira, 19 de outubro de 2024
                    <div class="tem-vagas">
                        8 vagas disponíveis
                    </div>
                </div>
                <div class="collapsible-body"><p>Lorem ipsum dolor sit amet.</p></div>
            </li>
            <li>
                <div class="collapsible-header">
                    <i class="material-icons">local_dining</i>
                    Sexta-Feira, 20 de outubro de 2024
                    <div class="nao-tem-vagas">
                        0 vagas disponíveis
                    </div>
                </div>
                <div class="collapsible-body"><p>Lorem ipsum dolor sit amet.</p></div>
            </li>
        </ul>

    </div>


    </main>    
    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="js/materialize.min.js"></script>
     <!--  Scripts-->
     <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="https://www.um.es/docencia/barzana/materializecss/bin/materialize.js"></script>
</body>
</html>
