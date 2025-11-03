<?php
require_once "conecta.php";
require 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Configurar opções do DOMPDF
$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);

// Obtendo o ID do usuário diretamente do parâmetro GET
$usuario_id = $_GET['id'];

// Consultar informações do usuário
$consulta_usuario = "SELECT nome, cpf FROM usuario WHERE id = $usuario_id";
$resultado_usuario = mysqli_query($conexao, $consulta_usuario);

$nome_usuario = "Usuário não encontrado";
$cpf_usuario = "CPF não encontrado";

if ($resultado_usuario && mysqli_num_rows($resultado_usuario) > 0) {
    $dados_usuario = mysqli_fetch_assoc($resultado_usuario);
    $nome_usuario = $dados_usuario['nome'];
    $cpf_usuario = $dados_usuario['cpf'];
}

// Consulta para buscar as ocorrências
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

// Gerar HTML para o relatório
$dados = '
<html>
<head>
<style>
body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 20px;
  line-height: 1.6;
  color: black;
}
h1 {
  text-align: center;
  color: #006d38;
  margin-bottom: 30px;
}
.informacoes-usuario {
  text-align: center;
  margin-bottom: 20px;
}

table {
  border-collapse: collapse;
  width: 100%;
  margin-top: 20px;
}
td, th {
  text-align: left;
  padding: 10px;
  border: 1px solid #ddd;
}
tr:nth-child(even) {
  background-color: #f9f9f9;
}
thead {
  background-color: #006d38;
  color: white;
}
.presente {
  color: green;
  font-weight: bold;
}
.ausente {
  color: red;
  font-weight: bold;
}
</style>
</head>
<body>
';

$dados .= "<h1>Relatório de Ocorrências do Usuário</h1>";
$dados .= '<div class="informacoes-usuario">';
$dados .= "<p><span >Nome:</span> $nome_usuario </P>";
$dados .="</p> <span>CPF:</span> $cpf_usuario</p>";

$dados .= "<table>
        <thead>
          <tr>
          <th>Data</th>
          <th>Presença no Almoço</th>
          <th>Presença na Atividade</th>
          </tr>
        </thead>
        <tbody>";

if (mysqli_num_rows($resultado) > 0) {
    while ($linha = mysqli_fetch_assoc($resultado)) {
        $dados .= "<tr>";
        $dados .= "<td>" . date('d/m/Y', strtotime($linha['data_ocorrencia'])) . "</td>";
        $dados .= "<td>" . ($linha['presencaAlmoco'] == 1 
            ? '<span class="presente">Presente</span>' 
            : '<span class="ausente">Ausente</span>') . "</td>";
        $dados .= "<td>" . ($linha['presencaAtividade'] == 1 
            ? '<span class="presente">Presente</span>' 
            : '<span class="ausente">Ausente</span>') . "</td>";
        $dados .= "</tr>";
    }
} else {
    $dados .= "<tr><td colspan='3'>Nenhuma ocorrência encontrada.</td></tr>";
}

$dados .= "</tbody>";
$dados .= "</table>";
$dados .= "</body></html>";

// Carregar o HTML no DOMPDF
$dompdf->loadHtml($dados);

// Definir o tamanho e a orientação do papel
$dompdf->setPaper('A4', 'portrait');

// Renderizar o PDF
$dompdf->render();

// Enviar o PDF para o navegador
$dompdf->stream("relatorio_ocorrencias.pdf", ["Attachment" => true]);
?>