<?php
$paginaCorrente = basename($_SERVER['SCRIPT_NAME']);
?>

<!-- Navbar -->
<nav class="navbar fixed">
    <div class="navbar-wrapper">
        <nav class="green lighten-5">
            <div class="nav-wrapper container">
                <!-- Logo ajustado com classe -->
                <a href="inicioaluno.php" class="brand-logo">
                    <img src="img/logonome.png" alt="Logo" class="logo">
                </a>
                <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>

                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li <?php if ($paginaCorrente == 'inicioaluno.php') {
                            echo 'class="active"';
                        } ?>>
                        <a class="black-text" href="inicioaluno.php">Home</a>
                    </li>
                    <li>
                        <a href="#agendamento" class="black-text">Agendamento</a>
                    </li>
                    <li>
                        <a href="#meusAgendamentos" class="black-text">Meus Agendamentos</a>
                    </li>
                    <li>
                        <a href="#perguntas" class="black-text">Perguntas Frequentes</a>
                    </li>
                    <a href="perfil.php?id=<?php echo $_SESSION['id']; ?>" class="waves-effect waves-light btn-small green">
                        <i class="material-icons">person</i> Perfil
                    </a>

                    <li>
                        <a href="sair.php" class="waves-effect waves-light btn-small green">
                            <i class="material-icons">exit_to_app</i> Sair
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Mobile Menu -->
        <ul class="sidenav" id="mobile-demo">
            <li <?php if ($paginaCorrente == 'inicioaluno.php') {
                    echo 'class="active"';
                } ?>>
                <a class="black-text" href="inicioaluno.php">Home</a>
            </li>
            <li>
                <a href="#agendamento" class="black-text">Agendamento</a>
            </li>
            <li>
                <a href="#meusAgendamentos" class="black-text">Meus Agendamentos</a>
            </li>
            <li>
                <a href="#perguntas" class="black-text">Perguntas Frequentes</a>
            </li>
            <li>
            <a href="perfil.php?id=<?php echo $_SESSION['id']; ?>" class="waves-effect waves-light btn-small green">
                        <i class="material-icons">person</i> Perfil
                    </a>
            </li>

            <li>
                <a href="sair.php" class="waves-effect waves-light btn-small green">
                    <i class="material-icons">exit_to_app</i> Sair
                </a>
            </li>
        </ul>
    </div>
</nav>

<!-- CSS para alinhar o botão de logout à direita -->
<style>
    /* Navbar fixa com z-index alto */
    .navbar {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1000; /* Garante que a navbar tenha um índice alto */
    }

    /* Sidebar com z-index maior que o da navbar */
    .sidenav {
        z-index: 1050; /* Maior que o z-index da navbar */
    }

    /* Conteúdo da página para evitar que fique por baixo da navbar */
    main {
        margin-top: 80px; /* Ajuste a margem para não sobrepor a navbar */
    }

    /* Menu de navegação com alinhamento à direita para o botão de sair */
    #nav-mobile {
        display: flex;
        align-items: center;
    }

    #nav-mobile li:last-child {
        margin-left: auto;
        /* Garante que o último item (logout) vá para o canto direito */
    }
</style>

<!-- Importação dos Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.sidenav');
        M.Sidenav.init(elems); // Inicializa a sidebar
    });

    // Ou com jQuery
    $(document).ready(function() {
        $('.sidenav').sidenav(); // Inicia a sidebar usando jQuery
    });
</script>
