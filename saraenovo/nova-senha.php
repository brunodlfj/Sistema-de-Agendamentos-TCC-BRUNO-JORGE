<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Sarae IFFAR UG</title>
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<link rel="shortcut icon" type="image/png" href="img/iconejanela.png" />
<body>
    <main class="container">
        <h1 class="center-align">Redefinir senha</h1>


        <?php  
require_once "conecta.php";
session_start();

// Verificar se existem mensagens de erro na sessão
if (isset($_SESSION['erros']) && !empty($_SESSION['erros'])): ?>
    <div class="card-panel red lighten-4">
        <ul>
            <?php foreach ($_SESSION['erros'] as $erro): ?>
                <li class="red-text text-darken-4"><?php echo $erro; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php unset($_SESSION['erros']); // Limpa as mensagens de erro após exibir ?>
<?php endif; ?>




        <form action="salvar-nova-senha.php" method="POST">
            <div class="card-panel">
                <h4>Formulário</h4>
                <!-- Campos ocultos para email e token -->
                <input type="hidden" name="email" value="<?= isset($_GET['email']) ? $_GET['email'] : '' ?>">
                <input type="hidden" name="token" value="<?= isset($_GET['token']) ? $_GET['token'] : '' ?>">

                <!-- Exibição do email -->
                <p>Email: <?= isset($_GET['email']) ? $_GET['email'] : 'Não informado' ?></p>

                <!-- Campo Nova Senha -->
                <div class="input-field">
                    <input type="password" id="senha" name="senha" required>
                    <label for="senha">Nova Senha</label>
                </div>

                <!-- Campo Repetir Senha -->
                <div class="input-field">
                    <input type="password" id="repetirSenha" name="repetirSenha" required>
                    <label for="repetirSenha">Repita a Senha</label>
                </div>

                <!-- Botão de envio -->
                <div class="row">
                    <div class="col s12">
                        <p class="center-align">
                            <button type="submit" name="submit" class="btn waves-effect waves-light" style="background-color: #006d38;">
                                Salvar nova senha
                                <i class="material-icons right">send</i>
                            </button>
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </main>
    <script type="text/javascript" src="js/materialize.min.js"></script>
</body>
</html>
