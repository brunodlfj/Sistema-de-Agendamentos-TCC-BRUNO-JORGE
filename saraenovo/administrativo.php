<html>

<head>
    <title>Sarae IFFAR ug - Administrativo</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />
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

        table th,
        table td {
            text-align: left;
        }

        .btn-column {
            text-align: center;
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

    include_once "headeradm.php";
    include "conecta.php";
    ?>

    <main class="container">
        <br><br><h1>Relatório de Faltas</h1>
        <table>
            <thead>
                <tr>
                    <th>Nome do Usuário</th>
                    <th>Total de Faltas</th>
                    <th class="btn-column">Ocorrência</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // SQL ajustado
                $sql = "
                    SELECT 
                        u.id AS usuario_id, 
                        u.nome AS usuario_nome, 
                        SUM(CASE WHEN a.presencaAlmoco = 0 THEN 1 ELSE 0 END +
                            CASE WHEN a.presencaAtividade = 0 THEN 1 ELSE 0 END) AS total_faltas
                    FROM 
                        agendamento AS a
                    INNER JOIN 
                        usuario AS u 
                    ON 
                        a.id = u.id
                    WHERE
                        (a.presencaAlmoco IS NOT NULL AND a.presencaAtividade IS NOT NULL)  -- Garantir que os registros sejam lançados
                    GROUP BY 
                        u.id, u.nome
                    HAVING 
                        total_faltas > 0 -- Apenas usuários com faltas
                    ORDER BY 
                        total_faltas DESC
                ";

                $resultado = mysqli_query($conexao, $sql);

                while ($linha = mysqli_fetch_array($resultado)) {
                ?>
                    <tr>
                        <td><?php echo $linha['usuario_nome']; ?></td>
                        <td><?php echo $linha['total_faltas']; ?></td>
                        <td class="btn-column">
                            <a href="ocorrencia.php?id=<?php echo $linha['usuario_id']; ?>" 
                                class="btn-floating btn-small waves-effect waves-light blue">
                                <i class="material-icons">visibility</i>
                            </a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
       <br> <a href='relatoriofaltas.php' class="waves-effect waves-light btn" style="background-color: #006d38; color: white;"><i class="material-icons right">file_download</i>Gerar relatório</a>
       
    </main>

    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script>
// M.AutoInit();
   document.addEventListener('DOMContentLoaded', function() {
      var elems = document.querySelectorAll('.modal');
      var instances = M.Modal.init(elems, {
        opacity: 0.7,        // Opacidade do background (0.0 a 1.0)
        inDuration: 1000,     // Duração da animação de abertura em milissegundos
        outDuration: 1200,    // Duração da animação de fechamento em milissegundos
        dismissible: true,   // Permite fechar ao clicar fora do modal
        startingTop: '10%',  // Posição inicial do modal em relação ao topo
        endingTop: '15%'     // Posição final do modal em relação ao topo
      });
    });

    document.addEventListener('DOMContentLoaded', function() {
            // Inicializa a sidenav
            var elems = document.querySelectorAll('.sidenav');
            var instances = M.Sidenav.init(elems, {
                edge: 'left'});

            // Configura a largura da sidenav
            var sidenav = document.querySelector('.sidenav');
            sidenav.style.width = '250px'; // Ajuste a largura conforme necessário
        });



    
</script>
</body>

</html>