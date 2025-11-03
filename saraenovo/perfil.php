<?php
include "conecta.php";

// Obtenha o ID do usuário da URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Aqui você pode usar o $id para buscar informações do banco de dados, exibir o perfil do usuário, etc.
} else {
    echo "ID não fornecido.";
    exit();
}

// Consulta para obter os dados do usuário
$sql = "SELECT id, cpf, nome, email, nivel, situacaousuario FROM usuario WHERE id=$id";
$resultado = mysqli_query($conexao, $sql);
$usuario = mysqli_fetch_array($resultado);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sarae IFFAR UG</title>

    <!-- Import Google Icon Font -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Import Materialize CSS -->
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection"/>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/png" href="img/iconejanela.png" />
</head>
<body>

<main class="container">
    <h1 class="center-align">Editar Informações de Perfil</h1>
    <div class="row">
        <form class="col s12" action="atualizarperfil.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">

            <!-- Nome - Somente leitura -->
            <div class="input-field col s12">
                <input type="text" id="nome" name="nome" value="<?php echo $usuario['nome']; ?>" readonly>
                <label for="nome">Nome</label>
            </div>

            <!-- Email - Editável -->
            <div class="input-field col s12">
                <input type="email" id="email" name="email" value="<?php echo $usuario['email']; ?>">
                <label for="email">Email</label>
            </div>

            <!-- CPF - Somente leitura -->
            <div class="input-field col s12">
                <input type="text" id="cpf" name="cpf" value="<?php echo $usuario['cpf']; ?>" readonly>
                <label for="cpf">CPF</label>
            </div>

            <!-- Nova Senha -->
            <div class="input-field col s12">
                <input type="password" id="senha" name="senha" required>
                <label for="senha">Nova Senha</label>
            </div>

            <!-- Repetir Senha -->
            <div class="input-field col s12">
                <input type="password" id="repetirSenha" name="repetirSenha" required>
                <label for="repetirSenha">Repita a Senha</label>
            </div>

            <button type="submit" class="btn waves-effect waves-light green">Atualizar</button>

            <!-- Lógica de redirecionamento baseado no 'nivel' -->
            <?php
                $redirect_url = "inicioaluno.php"; // Default
                if ($usuario['nivel'] == 1) {
                    $redirect_url = "inicioprofessor.php";
                } elseif ($usuario['nivel'] == 2) {
                    $redirect_url = "inicioadm.php";
                }
            ?>
            <a href="<?php echo $redirect_url; ?>" class="btn waves-effect waves-light red">Cancelar</a>
        </form>
    </div>
</main>

<!-- Import jQuery before materialize.js -->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="js/materialize.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('select');
    M.FormSelect.init(elems);
});
</script>
</body>
</html>
