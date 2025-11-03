<!DOCTYPE html>
<html>

<head>
    <title>Sarae IFFAR ug - Regras</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
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

    /* Centraliza os botões de editar e excluir apenas, sem afetar outras colunas */
    table td.btn-column, table th:nth-child(3), table th:nth-child(4) {
        text-align: center;
    }

    /* Centraliza o conteúdo da tabela, exceto os botões de editar e excluir */
    table thead th, table tbody td {
        text-align: left;
    }
</style>

<link rel="shortcut icon" type="image/png" href="img/iconejanela.png" />

<body>
    <?php
    session_start();
    if (!isset($_SESSION['cpf']) || $_SESSION['nivel'] != 2) {
        header('Location: index.php');
        exit();
    }

    include_once "headeradm.php";
    require_once 'conecta.php'; 
    ?>

    <main class="container">
        <br><br><h1>Regras</h1>
        <br>
        <a class="waves-effect waves-light btn" href="formularioregra.php" style="background-color: #006d38; color: white;">
            <i class="material-icons left">add</i>Adicionar Nova Regra
        </a>
        <h5>Lista de Regras Cadastradas:</h5>

        <table>
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Corpo</th>
                    <th>Editar</th>
                    <th>Excluir</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM regra"; // Ajuste a consulta conforme o seu banco de dados
                $resultado = mysqli_query($conexao, $sql);
                
                while ($linha = mysqli_fetch_array($resultado)) {
                ?>
                    <tr>
                        <td><?php echo $linha['titulo']; ?></td>
                        <td><?php echo $linha['corpo']; ?></td>
                        <td class="btn-column">
                            <a href="editarregra.php?id=<?php echo $linha['idRegra']; ?>" class="btn-floating btn-small waves-effect waves-light green">
                                <i class="material-icons">edit</i>
                            </a>
                        </td>
                        <td class="btn-column">
                            <a href="#modal<?php echo $linha['idRegra']; ?>" 
                               class="btn-floating btn-small waves-effect waves-light red modal-trigger">
                                <i class="material-icons">delete</i>
                            </a>
                        </td>
                    </tr>
                    <div id="modal<?php echo $linha['idRegra']; ?>" class="modal">
                        <div class="modal-content">
                            <h4>Atenção!</h4>
                            <p>Você confirma a exclusão da regra <?php echo $linha['titulo']; ?>?</p>
                        </div>
                        <div class="modal-footer">
                            <form action="excluirregra.php" method="POST">
                                <input type="hidden" name="idRegra" value="<?php echo $linha['idRegra']; ?>">
                                <button type="submit" name="btn-deletar" 
                                    class="modal-action modal-close waves-red btn red darken-1">Excluir</button>
                                <button type="button" name="btn-cancelar" 
                                    class="modal-action modal-close btn waves-light green">Cancelar</button>
                            </form>
                        </div>
                    </div>
                <?php
                }
                ?>
            </tbody>
        </table>
    </main>

    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="https://www.um.es/docencia/barzana/materializecss/bin/materialize.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var elems = document.querySelectorAll('select');
            var instances = M.FormSelect.init(elems);
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('.modal');
            var instances = M.Modal.init(elems);
        });
    </script>
</body>

</html>
