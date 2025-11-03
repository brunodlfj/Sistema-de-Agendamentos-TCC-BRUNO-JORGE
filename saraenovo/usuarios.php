<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>Sarae IFFAR ug</title>
    <meta charset="UTF-8">
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="img/iconejanela.png" />
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

        .table-title {
            margin-top: 20px;
        }
        table {
            width: 100%;
        }

        table th, table td {
            text-align: left; /* Mantém o alinhamento padrão */
        }

    </style>
</head>

<body>
    <?php
    include_once "headeradm.php";
    include "conecta.php";
    ?>
    <main class="container">
        <br><br><h1>Usuários</h1>

        <div style="display: inline-flex; align-items: center;">
            <input type="text" id="search" placeholder="Buscar usuário" onkeyup="searchUsers()">
            <i class="material-icons">search</i>
        </div>
        <br><br>

        <h5 class="table-title">Usuários Ativos</h5>
        <table>
            <thead>
                <tr>
                    
                    <th>CPF</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Nível</th>
                    <th>Editar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Selecionar usuários ativos (situacaousuario = 0)
                $sqlAtivos = "SELECT id, cpf, nome, email, nivel FROM usuario WHERE situacaousuario = 0";
                $resultadoAtivos = mysqli_query($conexao, $sqlAtivos);
                while ($linha = mysqli_fetch_array($resultadoAtivos)) {
                ?>
                    <tr>
                        
                        <td><?php echo $linha['cpf']; ?></td>
                        <td><?php echo $linha['nome']; ?></td>
                        <td><?php echo $linha['email']; ?></td>
                        <td>
                            <?php
                            switch ($linha['nivel']) {
                                case 0:
                                    echo "Aluno";
                                    break;
                                case 1:
                                    echo "Professor";
                                    break;
                                case 2:
                                    echo "Administrador";
                                    break;
                            }
                            ?>
                        </td>
                        <td>
                            <a href="editarusuario.php?id=<?php echo $linha['id']; ?>" class="btn-floating btn-small waves-effect waves-light green">
                                <i class="material-icons">edit</i>
                            </a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
        <br><br>

        <!-- Tabela de usuários inativos -->
        <h5 class="table-title">Usuários Inativos</h5>
        <table>
            <thead>
                <tr>
                    <th>CPF</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Nível</th>
                    <th>Editar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Selecionar usuários inativos (situacaousuario = 1)
                $sqlInativos = "SELECT id, cpf, nome, email, nivel FROM usuario WHERE situacaousuario = 1";
                $resultadoInativos = mysqli_query($conexao, $sqlInativos);
                while ($linha = mysqli_fetch_array($resultadoInativos)) {
                ?>
                    <tr>
                        <td><?php echo $linha['cpf']; ?></td>
                        <td><?php echo $linha['nome']; ?></td>
                        <td><?php echo $linha['email']; ?></td>
                        <td>
                            <?php
                            switch ($linha['nivel']) {
                                case 0:
                                    echo "Aluno";
                                    break;
                                case 1:
                                    echo "Professor";
                                    break;
                                case 2:
                                    echo "Administrador";
                                    break;
                            }
                            ?>
                        </td>
                        <td>
                            <a href="editarusuario.php?id=<?php echo $linha['id']; ?>" class="btn-floating btn-small waves-effect waves-light green">
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

    <!-- Import jQuery before materialize.js -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/materialize.min.js"></script>

    <script>
        // Função para filtrar as tabelas
        function searchUsers() {
            var input = document.getElementById("search");
            var filter = input.value.toLowerCase();
            var tables = document.querySelectorAll("tbody");
            tables.forEach(function(table) {
                var tr = table.getElementsByTagName("tr");
                for (var i = 0; i < tr.length; i++) {
                    var txtValue = tr[i].textContent || tr[i].innerText;
                    tr[i].style.display = txtValue.toLowerCase().includes(filter) ? "" : "none";
                }
            });
        }
    </script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
</body>

</html>