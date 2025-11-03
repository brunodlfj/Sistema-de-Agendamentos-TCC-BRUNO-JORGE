<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Sarae IFFAR UG - Cadastro de Usuário</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection"/>
    <link rel="shortcut icon" type="image/png" href="img/iconejanela.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body>

<main class="container">
    <h1 class="center-align">Cadastro de Usuário</h1>

    <!-- Exibe mensagens de erro se existirem -->
    <?php if (isset($_SESSION['erros']) && !empty($_SESSION['erros'])): ?>
        <div class="card-panel red lighten-4">
            <ul>
                <?php foreach ($_SESSION['erros'] as $erro): ?>
                    <li class="red-text text-darken-4"><?php echo $erro; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php unset($_SESSION['erros']); // Limpa as mensagens de erro após exibir ?>
    <?php endif; ?>

    <form action="cadastro.php" method="POST">
    <div class="card-panel">
        <h4>Formulário</h4>

        <div class="input-field col s12">
            <input id="nome" type="text" class="validate" name="nome" required>
            <label for="nome">Nome</label>
        </div>

        <div class="input-field col s12">
            <input type="text" id="cpf" name="cpf" class="validate" pattern="\d{11}" maxlength="11" required>
            <label for="cpf">CPF</label>
        </div>

        <div class="input-field col s12">
            <input type="email" id="email" name="email" class="validate" required>
            <label for="email">Email</label>
        </div>

        <div class="input-field col s12">
            <input type="password" id="senha" name="senha" required>
            <label for="senha">Senha</label>
        </div>

        <div class="input-field col s12">
            <input type="password" id="senha_repetir" name="senha_repetir" required>
            <label for="senha_repetir">Repetir Senha</label>
        </div>

        <div class="row">
            
                <button type="submit" name="submit" class="btn waves-effect waves-light" style="background-color: #006d38;">
                    Cadastrar
                    <i class="material-icons right">send</i>
                </button>
                <a href="index.php" class="btn waves-effect waves-light red">Voltar</a>
                </form>
        </div>
    </div>
</form>

</main>

<script type="text/javascript" src="js/materialize.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        M.updateTextFields();
    });
</script>

</body>
</html>
