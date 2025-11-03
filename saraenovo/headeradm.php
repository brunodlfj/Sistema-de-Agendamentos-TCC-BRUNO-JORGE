<?php
ob_start(); // Inicia o buffer de saída para evitar erros de header

// Verifica se a sessão não está ativa antes de iniciar
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Inicia a sessão
}

$paginaCorrente = basename($_SERVER['SCRIPT_NAME']);
?>

<nav class="navbar fixed">
    <div class="navbar-wrapper">
        <nav class="green lighten-5">
            <div class="nav-wrapper container">
                <!-- Logo ajustado com classe -->
                <a href="inicioadm.php" class="brand-logo">
                    <img src="img/logonome.png" alt="Logo" class="logo">
                </a>
                <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>

                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li <?php echo ($paginaCorrente == 'inicioadm.php') ? 'class="active"' : ''; ?>>
                        <a class="black-text" href="inicioadm.php">Home</a>
                    </li>
                    <li <?php echo ($paginaCorrente == 'usuarios.php') ? 'class="active"' : ''; ?>>
                        <a class="black-text" href="usuarios.php">Usuários</a>
                    </li>
                    <li <?php echo ($paginaCorrente == 'administrativo.php') ? 'class="active"' : ''; ?>>
                        <a class="black-text" href="administrativo.php">Administrativo</a>
                    </li>
                    <li <?php echo ($paginaCorrente == 'regra.php') ? 'class="active"' : ''; ?>>
                        <a class="black-text" href="regra.php">Regras</a>
                    </li>
                    <li>
                        <a href="perfil.php?id=<?php echo isset($_SESSION['id']) ? $_SESSION['id'] : ''; ?>" class="waves-effect waves-light btn-small green">
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

        <!-- Mobile Menu -->
        <ul class="sidenav" id="mobile-demo">
            <li <?php echo ($paginaCorrente == 'inicioadm.php') ? 'class="active"' : ''; ?>>
                <a class="black-text" href="inicioadm.php">Home</a>
            </li>
            <li <?php echo ($paginaCorrente == 'usuarios.php') ? 'class="active"' : ''; ?>>
                <a class="black-text" href="usuarios.php">Usuários</a>
            </li>
            <li <?php echo ($paginaCorrente == 'administrativo.php') ? 'class="active"' : ''; ?>>
                <a class="black-text" href="administrativo.php">Administrativo</a>
            </li>
            <li <?php echo ($paginaCorrente == 'regra.php') ? 'class="active"' : ''; ?>>
                <a class="black-text" href="regra.php">Regras</a>
            </li>
            <li>
                <a href="perfil.php?id=<?php echo isset($_SESSION['id']) ? $_SESSION['id'] : ''; ?>" class="waves-effect waves-light btn-small green">
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
    .navbar {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1000;
    }

    .sidenav {
        z-index: 1050;
    }

    main {
        margin-top: 80px;
    }

    #nav-mobile {
        display: flex;
        align-items: center;
    }

    #nav-mobile li:last-child {
        margin-left: auto;
    }
</style>

<!-- Importação dos Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.sidenav');
        M.Sidenav.init(elems);
    });

    $(document).ready(function() {
        $('.sidenav').sidenav();

        $('a[href^="#"]').on('click', function(e) {
            e.preventDefault();
            var target = this.hash;
            var $target = $(target);

            $('html, body').animate({
                scrollTop: $target.offset().top
            }, 1000, 'swing');
        });
    });
</script>
