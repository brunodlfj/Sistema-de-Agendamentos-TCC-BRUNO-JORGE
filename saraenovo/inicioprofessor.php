<!DOCTYPE html>
<html>

<head>
    <title>Sarae IFFAR ug</title>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

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

        table {
            width: 100%;
        }

        table th, table td {
            text-align: left; /* Mantém o alinhamento padrão */
        }

        .btn-column {
            text-align: center; /* Centraliza apenas as colunas com botões */
        }

        .btn-floating {
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>

<link rel="shortcut icon" type="image/png" href="img/iconejanela.png" />

<body>
    <?php
    session_start();
    if (!isset($_SESSION['cpf'])) {
        header('Location: index.php');
        exit();
    }
    $id = $_SESSION['id'];
    include_once "headerprofessor.php";

    ?>
       <?php
include "conecta.php";


// Verifica a situação do usuário
$sqlSituacao = "SELECT situacaousuario FROM usuario WHERE id = $id";
$resultSituacao = mysqli_query($conexao, $sqlSituacao);
$situacaoUsuario = mysqli_fetch_assoc($resultSituacao)['situacaousuario'];

if ($situacaoUsuario == 1) {
    // Usuário inativo: exibe mensagem de atenção
    echo "
    <div class='container' style='margin-top: 20px;'>
       <br> <h1 style='color: red; text-align: center;'>Atenção!</h1>
        <p style='text-align: center; font-size: 1.2rem;'>
            Docente sua conta foi temporariamente desativada no sistema pelo administrador. 
            Por favor, entre em contato com a assistência para mais informações.
        </p>
    </div>";
    exit(); // Interrompe o carregamento do restante da página
}
?>
    <div class="parallax-container">
      <div class="parallax"><img src="img/imgtelainicio.png"></div>
    </div>
    <main class="container">
        

        

        <!-- Atividades Ativas -->
        <br><br><h4 class="header" id="minhasatividades">Minhas atividades</h4><br>
        <a class="waves-effect waves-light btn" href="formularioatividade.php" style="background-color: #006d38; color: white;">
            <i class="material-icons left">add</i>Adicionar atividade
        </a>
        <table>
            <thead>
                <tr>
                    
                    <th>Atividade</th>
                    <th>Dia da semana</th>
                    <th class="btn-column">Visualizar</th>
                    <th class="btn-column">Editar</th>
                    <th class="btn-column">Excluir</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sqlAtivas = "SELECT idAtividade, nome, diadasemana FROM atividade WHERE id = $id AND situacao = 0";
                $resultadoAtivas = mysqli_query($conexao, $sqlAtivas);
                while ($linha = mysqli_fetch_array($resultadoAtivas)) {
                ?>
                    <tr>
                        
                        <td><?php echo $linha['nome']; ?></td>
                        <td>
                            <?php
                            switch ($linha['diadasemana']) {
                                case 2: echo "Segunda-Feira"; break;
                                case 3: echo "Terça-Feira"; break;
                                case 4: echo "Quarta-Feira"; break;
                                case 5: echo "Quinta-Feira"; break;
                                case 6: echo "Sexta-Feira"; break;
                            }
                            ?>
                        </td>
                        <td class="btn-column">
                            <a href="visualizaratividade.php?id=<?php echo $linha['idAtividade']; ?>" 
                               class="btn-floating btn-small waves-effect waves-light blue">
                                <i class="material-icons">visibility</i>
                            </a>
                        </td>
                        <td class="btn-column">
                            <a href="editaratividade.php?id=<?php echo $linha['idAtividade']; ?>" 
                               class="btn-floating btn-small waves-effect waves-light green">
                                <i class="material-icons">edit</i>
                            </a>
                        </td>
                        <td class="btn-column">
                            <a href="#modal<?php echo $linha['idAtividade']; ?>" 
                               class="btn-floating btn-small waves-effect waves-light red modal-trigger">
                                <i class="material-icons">delete</i>
                            </a>
                        </td>
                    </tr>

                    <!-- Modal de Exclusão -->
                    <div id="modal<?php echo $linha['idAtividade']; ?>" class="modal">
                        <div class="modal-content">
                            <h4>Atenção!</h4>
                            <p>Você confirma a exclusão da atividade <?php echo $linha['nome']; ?>?</p>
                        </div>
                        <div class="modal-footer">
                            <form action="excluiratividade.php" method="POST">
                                <input type="hidden" name="idAtividade" value="<?php echo $linha['idAtividade']; ?>">
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

        <!-- Atividades Anteriores (Inativas) -->
        <h4 class="header" id="atividadesanteriores">Atividades Anteriores</h4>
        <table>
            <thead>
                <tr>
                    
                    <th>Atividade</th>
                    <th>Dia da semana</th>
                    <th class="btn-column">Visualizar</th>
                    <th class="btn-column">Editar</th>
                  
                </tr>
            </thead>
            <tbody>
                <?php
                $sqlAnteriores = "SELECT idAtividade, nome, diadasemana FROM atividade WHERE id = $id AND situacao = 1";
                $resultadoAnteriores = mysqli_query($conexao, $sqlAnteriores);
                while ($linha = mysqli_fetch_array($resultadoAnteriores)) {
                ?> 
                    <tr>
                       
                        <td><?php echo $linha['nome']; ?></td>
                        <td>
                            <?php
                            switch ($linha['diadasemana']) {
                                case 2: echo "Segunda-Feira"; break;
                                case 3: echo "Terça-Feira"; break;
                                case 4: echo "Quarta-Feira"; break;
                                case 5: echo "Quinta-Feira"; break;
                                case 6: echo "Sexta-Feira"; break;
                            }
                            ?>
                        </td>
                        <td class="btn-column">
                            <a href="visualizaratividade.php?id=<?php echo $linha['idAtividade']; ?>" 
                               class="btn-floating btn-small waves-effect waves-light blue">
                                <i class="material-icons">visibility</i>
                            </a>
                        </td>
                        <td class="btn-column">
                            <a href="editaratividade.php?id=<?php echo $linha['idAtividade']; ?>" 
                               class="btn-floating btn-small waves-effect waves-light green">
                                <i class="material-icons">edit</i>
                            </a>
                        </td>
                      
                    </tr>

                
                <?php
                }
                ?>
            </tbody>
        </table>

    </main>
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('.modal');
            var instances = M.Modal.init(elems);
        });
    </script>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.parallax');
    M.Parallax.init(elems);
  });
</script>

</body>

</html>
