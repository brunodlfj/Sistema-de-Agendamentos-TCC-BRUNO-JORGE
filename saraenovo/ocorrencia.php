<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Ocorrências do Usuário</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <style>
        table {
            width: 100%;
        }

        table th,
        table td {
            text-align: left;
        }

        .icon-correct {
            color: green;
        }

        .icon-wrong {
            color: red;
        }
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
</head>

<link rel="shortcut icon" type="image/png" href="img/iconejanela.png" />

<body>
    <?php
    session_start();
    if (!isset($_SESSION['cpf'])) {
        header('Location: index.php');
        exit();
    }

    include_once "headeradm.php"; 
    include "conecta.php";

    // Obtendo o ID do usuário selecionado
    $usuario_id = $_GET['id'];

    // Consulta para buscar o nome e CPF do usuário
    $consulta_usuario = "SELECT nome, cpf FROM usuario WHERE id = $usuario_id";
    $resultado_usuario = mysqli_query($conexao, $consulta_usuario);
    $nome_usuario = "Usuário não encontrado";
    $cpf_usuario = "CPF não encontrado";
    if ($resultado_usuario && mysqli_num_rows($resultado_usuario) > 0) {
        $dados_usuario = mysqli_fetch_assoc($resultado_usuario);
        $nome_usuario = $dados_usuario['nome'];
        $cpf_usuario = $dados_usuario['cpf'];
    }

    // Ajustando a consulta para as ocorrências
    $sql = "
        SELECT 
            d.dia AS data_ocorrencia,
            a.presencaAlmoco,
            a.presencaAtividade
        FROM 
            agendamento AS a
        INNER JOIN 
            diacontemplado AS d ON a.idContemplado = d.idContemplado
        WHERE 
            a.id = $usuario_id
            AND (
                (a.presencaAlmoco = 0 AND a.presencaAtividade = 1) OR
                (a.presencaAlmoco = 1 AND a.presencaAtividade = 0) OR
                (a.presencaAlmoco = 0 AND a.presencaAtividade = 0)
            )
        ORDER BY 
            d.dia ASC
    ";

    $resultado = mysqli_query($conexao, $sql);
    ?>

    <main class="container">
        <br> <h1>Ocorrências do Usuário</h1>
        <h5>Nome: <?php echo $nome_usuario; ?></h5>
        <h6>CPF: <?php echo $cpf_usuario; ?></h6>
        <table>
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Presença no Almoço</th>
                    <th>Presença na Atividade</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($resultado) > 0) {
                    while ($linha = mysqli_fetch_array($resultado)) {
                ?>
                        <tr>
                            <td><?php echo date('d/m/Y', strtotime($linha['data_ocorrencia'])); ?></td>
                            <td>
                                <?php
                                echo $linha['presencaAlmoco'] == 1
                                    ? '<i class="material-icons icon-correct">check</i>'
                                    : '<i class="material-icons icon-wrong">close</i>';
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $linha['presencaAtividade'] == 1
                                    ? '<i class="material-icons icon-correct">check</i>'
                                    : '<i class="material-icons icon-wrong">close</i>';
                                ?>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='3'>Nenhuma ocorrência encontrada.</td></tr>";
                }
                ?>
            </tbody>
        </table><br><br>
        <br> <a href='relatorioocorrencia.php?id=<?php echo $usuario_id; ?>' class="waves-effect waves-light btn" style="background-color: #006d38; color: white;">
    <i class="material-icons right">file_download</i>Gerar relatório
</a>

        <a href="administrativo.php" class="btn waves-effect waves-light red">Voltar</a>
    </main>

    <script type="text/javascript" src="js/materialize.min.js"></script>
   
</body>

</html>
