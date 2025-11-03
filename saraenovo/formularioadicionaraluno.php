<?php
include_once "headeradm.php";
include "conecta.php";

// Recebe o idContemplado via GET
$idContemplado = isset($_GET['id']) ? $_GET['id'] : 'N/A';  

// Consulta para obter a data do dia contemplado
$dataContemplado = null;
if ($idContemplado != 'N/A') {
    $sqlData = "SELECT dia FROM diacontemplado WHERE idContemplado = '$idContemplado'";
    $resultadoData = mysqli_query($conexao, $sqlData);
    if ($resultadoData && mysqli_num_rows($resultadoData) > 0) {
        $linhaData = mysqli_fetch_array($resultadoData);
        $dataContemplado = $linhaData['dia'];  // Data no formato Y-m-d
    }
}

// Formata a data para o formato desejado: "Dia da semana, número do mês de mês do ano"
if ($dataContemplado) {
    $dataFormatada = date('l, d \d\e F \d\e Y', strtotime($dataContemplado));
    // Traduz para português
    $diasSemana = [
        "Sunday" => "Domingo", "Monday" => "Segunda-feira", "Tuesday" => "Terça-feira", 
        "Wednesday" => "Quarta-feira", "Thursday" => "Quinta-feira", "Friday" => "Sexta-feira", 
        "Saturday" => "Sábado"
    ];
    $meses = [
        "January" => "janeiro", "February" => "fevereiro", "March" => "março", "April" => "abril",
        "May" => "maio", "June" => "junho", "July" => "julho", "August" => "agosto", 
        "September" => "setembro", "October" => "outubro", "November" => "novembro", "December" => "dezembro"
    ];
    $dataFormatada = str_replace(array_keys($diasSemana), array_values($diasSemana), $dataFormatada);
    $dataFormatada = str_replace(array_keys($meses), array_values($meses), $dataFormatada);
}

// Processa o envio do formulário
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verifica se algum usuário foi selecionado
    if (isset($_POST['usuarios']) && !empty($_POST['usuarios'])) {
        // Obtém os IDs dos usuários selecionados
        $usuariosSelecionados = $_POST['usuarios'];

        // Verifica se o idContemplado foi recebido corretamente
        if ($idContemplado != 'N/A') {
            foreach ($usuariosSelecionados as $idUsuario) {
                // Insere os usuários selecionados na tabela de agendamento
                $sqlInsert = "INSERT INTO agendamento (id, idContemplado) VALUES ('$idUsuario', '$idContemplado')";
                if (mysqli_query($conexao, $sqlInsert)) {
                    echo "Usuário com ID $idUsuario agendado para o dia $idContemplado.<br>";
                } else {
                    echo "Erro ao agendar usuário com ID $idUsuario: " . mysqli_error($conexao) . "<br>";
                }
            }
        } else {
            echo "Erro: ID do dia contemplado não encontrado.";
        }
    } else {
        echo "Nenhum usuário selecionado.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <title>Sarae IFFAR UG</title>
    <meta charset="UTF-8">
    <!-- Import Materialize CSS -->
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="img/iconejanela.png"/>
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
    <h4> <?php echo $dataFormatada; ?></h4>
    <h5>Agendar refeição para um usuário extra </h5> 
    
    <!-- Barra de pesquisa -->
    <div style="display: flex; align-items: center;">
        <input type="text" id="search" placeholder="Buscar usuário" onkeyup="searchUsers()" style="flex-grow: 1; margin-right: 10px;">
        <i class="material-icons">search</i>
    </div> 
    <br><br>

    <!-- Tabela de usuários -->
    <form method="POST" action="cadastroalunoextra.php?id=<?php echo $idContemplado; ?>">
        <table>
            <thead>
                <tr>
                    <th>Selecionar</th>
                    <th>CPF</th>
                    <th>Nome</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody id="usersTable">
                <?php
                // Consulta para obter os usuários
                $sql = "SELECT id, cpf, nome, email FROM usuario WHERE nivel = 0";

                $resultado = mysqli_query($conexao, $sql);
                while ($linha = mysqli_fetch_array($resultado)) {
                ?>
                <tr>
                    <td>
                        <label>
                            <!-- Checkbox para permitir seleção, mas só pode selecionar um -->
                            <input type="checkbox" name="usuarios[]" value="<?php echo $linha['id']; ?>" class="filled-in" onclick="limitarSelecao(this)">
                            <span></span>
                        </label>
                    </td>
                    <td><?php echo $linha['cpf']; ?></td>
                    <td><?php echo $linha['nome']; ?></td>
                    <td><?php echo $linha['email']; ?></td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
        <br><br>
        <!-- Botão para enviar os usuários selecionados -->
        <button type="submit" class="waves-effect waves-light btn" style="background-color: #006d38; color: white;">
            <i class="material-icons right">check</i> Agendar Selecionado
        </button>
        
        <!-- Botão cancelar -->
        <a href="visualizardiacontemplado.php?id=<?php echo $idContemplado; ?>" class="btn waves-effect waves-light red">Cancelar</a>
    </form>
</main>

<!-- Import jQuery before Materialize.js -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/materialize.min.js"></script>

<script>
// Função para filtrar a tabela de usuários
function searchUsers() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("search");
    filter = input.value.toLowerCase();
    table = document.getElementById("usersTable");
    tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
        tr[i].style.display = "none";  // Inicialmente, esconde a linha
        td = tr[i].getElementsByTagName("td");
        for (var j = 0; j < td.length; j++) {
            if (td[j]) {
                txtValue = td[j].textContent || td[j].innerText;
                if (txtValue.toLowerCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";  // Mostra a linha se o filtro combinar
                    break;
                }
            }
        }
    }
}

// Função para limitar a seleção de checkbox para apenas um
function limitarSelecao(checkbox) {
    // Se a checkbox for marcada, desmarque todas as outras
    var checkboxes = document.getElementsByName('usuarios[]');
    checkboxes.forEach(function (box) {
        if (box !== checkbox) {
            box.checked = false;
        }
    });
}
</script>

</body>
</html>
