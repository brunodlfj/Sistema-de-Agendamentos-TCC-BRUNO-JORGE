<?php
session_start();
if (!isset($_SESSION['cpf']) || $_SESSION['nivel'] != 1) {
    header('Location: index.php');
    exit();
}

include_once "headerprofessor.php";
require_once 'conecta.php';

// Recebe o ID da atividade
$idAtividade = $_GET['id'];

// Inicializa a variável $resultado
$resultado = null;

// Consultando as informações da atividade
$sqlAtividade = "SELECT a.nome, a.diadasemana, a.situacao
                 FROM atividade a
                 WHERE a.idAtividade = '$idAtividade'
                 ";
$resultadoAtividade = mysqli_query($conexao, $sqlAtividade);
$atividade = null;
$diaAtividade = null;
$situacaoAtividade = null;
if ($resultadoAtividade && mysqli_num_rows($resultadoAtividade) > 0) {
    $linhaAtividade = mysqli_fetch_array($resultadoAtividade);
    $atividade = $linhaAtividade['nome'];  // Nome da atividade
    $diaAtividade = $linhaAtividade['diadasemana'];  // Dia da semana
    $situacaoAtividade = $linhaAtividade['situacao'];  // Situação da atividade (0 = ativa, 1 = inativa)
}

// Conversão do número do dia para o nome do dia da semana
$diasSemana = [
    1 => "Segunda-feira", 
    2 => "Terça-feira", 
    3 => "Quarta-feira", 
    4 => "Quinta-feira", 
    5 => "Sexta-feira", 
    6 => "Sábado", 
    7 => "Domingo"
];
$diaFormatado = $diasSemana[$diaAtividade] ?? "Dia inválido";

// Consultando a data do dia contemplado e os agendamentos
$sqlAgendamentos = "SELECT ag.idAgendamento, u.nome AS usuario, u.cpf, ag.presencaAtividade, dc.dia
                    FROM agendamento ag
                    LEFT JOIN usuario u ON ag.id = u.id
                    LEFT JOIN diacontemplado dc ON ag.idContemplado = dc.idContemplado
                    WHERE ag.idAtividade = '$idAtividade'
                    ORDER BY dc.dia DESC";

$resultadoAgendamentos = mysqli_query($conexao, $sqlAgendamentos);

// Processa o envio do formulário (salvar presença)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sucesso = true;  // Flag para verificar se tudo foi atualizado corretamente

    // Primeiro, atualizar todos os agendamentos como 0 (falta) para o dia contemplado
    $sqlAtualizarTodos = "UPDATE agendamento SET presencaAtividade = 0 WHERE idAtividade = '$idAtividade'";
    if (!mysqli_query($conexao, $sqlAtualizarTodos)) {
        $sucesso = false;
    }

    // Verifica se o campo 'presenca' está presente no POST
    if (isset($_POST['presenca']) && is_array($_POST['presenca'])) {
        // Atualiza a presença para os checkboxes marcados
        foreach ($_POST['presenca'] as $idAgendamento) {
            // Atualiza a coluna presencaAtividade para 1 (presente) no agendamento correspondente
            $sqlAtualizarPresenca = "UPDATE agendamento SET presencaAtividade = 1 WHERE idAgendamento = '$idAgendamento'";
            if (!mysqli_query($conexao, $sqlAtualizarPresenca)) {
                $sucesso = false;
            }
        }
    }

    // Armazenando a mensagem na sessão
    if ($sucesso) {
        $_SESSION['mensagem'] = 'Presenças registradas com sucesso!';
    } else {
        $_SESSION['mensagem'] = 'Houve um erro ao salvar as presenças.';
    }

    // Redireciona para a mesma página para recarregar os dados e exibir a mensagem
    header('Location: ' . $_SERVER['PHP_SELF'] . '?id=' . $idAtividade);
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Agendamentos - Atividade</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />
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
        
    </style>
</head>
<body>

<main class="container">
    <br><h1>Visualização de Agendamentos</h1> 
    <h5>Agendamentos para a atividade: <?php echo $atividade; ?>.</h5>
    <h6>Dia da Atividade: <?php echo $diaFormatado; ?></h6><br><br>

    <!-- Exibe a mensagem de sucesso ou erro -->
    <?php if (isset($_SESSION['mensagem'])): ?>
        <script>
            alert('<?php echo $_SESSION['mensagem']; ?>');
        </script>
        <?php unset($_SESSION['mensagem']); ?> <!-- Limpa a mensagem após exibição -->
    <?php endif; ?>

    <!-- Formulário para registrar presença -->
    <form method="POST">
        <table>
            <thead>
                <tr>
                    <th>Usuário</th>
                    <th>CPF</th>
                    <th>Data</th>
                    <th>Presença</th>
                </tr>
            </thead>
            <tbody>
    <?php
    if (mysqli_num_rows($resultadoAgendamentos) > 0) {
        // Exibe os agendamentos encontrados
        while ($linha = mysqli_fetch_array($resultadoAgendamentos)) {
            // Formata a data para o formato desejado (Ex: 2025-01-16)
            $dataContemplado = date('d/m/Y', strtotime($linha['dia']));
            
            // Marca a presença como checkbox, com valor 1 para presente
            $checked = ($linha['presencaAtividade'] == 1) ? "checked" : "";
            echo "<tr>";
            echo "<td>" . $linha['usuario'] . "</td>";
            echo "<td>" . $linha['cpf'] . "</td>";
            echo "<td>" . $dataContemplado . "</td>";  // Exibe a data
            echo "<td><label><input type='checkbox' name='presenca[]' value='" . $linha['idAgendamento'] . "' $checked class='filled-in'><span></span></label></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='4'>Nenhum agendamento encontrado para esta atividade.</td></tr>";
    }
    ?>
</tbody>
        </table> <br> <br> 

        <!-- Botão para salvar a presença -->
        <button type="submit" class="waves-effect waves-light btn" style="background-color: #006d38; color: white;" 
        <?php echo $situacaoAtividade == 1 ? 'disabled' : ''; ?>>
            <i class="material-icons right">done</i>Salvar Presença
        </button>
        <a href="inicioprofessor.php" class="btn waves-effect waves-light red">Voltar</a>

    </form>
</main>

<script type="text/javascript" src="js/materialize.min.js"></script>
</body>
</html>
