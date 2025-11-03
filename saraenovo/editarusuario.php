<!DOCTYPE html>
<html>
<head>
<title>Sarae IFFAR ug</title>
<meta charset="UTF-8">
   <!--Import Google Icon Font-->
   <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<!-- Import Materialize CSS -->
<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
<!-- Let browser know website is optimized for mobile -->
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<link rel="shortcut icon" type=/image/png href="img/iconejanela.png" />
<body>
<?php
include_once "headeradm.php";
include "conecta.php";
$id = $_GET['id'];

$sql = "SELECT id, cpf, nome, email, nivel, situacaousuario FROM usuario WHERE id=$id";
$resultado = mysqli_query($conexao, $sql);
$usuario = mysqli_fetch_array($resultado);
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
   <br><br> <h1>Editar Usuário</h1>
    <form action="atualizarusuario.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
        <div class="input-field">
            <input type="text" name="nome" value="<?php echo $usuario['nome']; ?>" readonly>
            <label>Nome</label>
        </div>
        <div class="input-field">
            <input type="email" name="email" value="<?php echo $usuario['email']; ?>" readonly>
            <label>Email</label>
        </div>
        <div class="input-field">
            <select name="nivel" required>
                <option value="0" <?php echo $usuario['nivel'] == 0 ? 'selected' : ''; ?>>Aluno</option>
                <option value="1" <?php echo $usuario['nivel'] == 1 ? 'selected' : ''; ?>>Professor</option>
                <option value="2" <?php echo $usuario['nivel'] == 2 ? 'selected' : ''; ?>>Administrador</option>
            </select>
            <label>Nível</label>
        </div>

        <div class="input-field col s12">
            <select id="situacao" name="situacaousuario" required>
                <option value="0" <?php echo $usuario['situacaousuario'] == 0 ? 'selected' : ''; ?>>Ativo</option>
                <option value="1" <?php echo $usuario['situacaousuario'] == 1 ? 'selected' : ''; ?>>Inativo</option>
            </select>
            <label for="situacao">Situação</label>
        </div>

        <button type="submit" class="btn waves-effect waves-light green">Atualizar Nível</button>
        <a href="usuarios.php" class="btn waves-effect waves-light red">Cancelar</a>
    </form>
</main>
<!-- Import jQuery before materialize.js -->
<script type="text/javascript" src="js/materialize.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  var elems = document.querySelectorAll('select');
  M.FormSelect.init(elems);
});
</script>
</body>
</html>

