<?php
require_once "conecta.php";
require 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;

// Configurar opções do DOMPDF
$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);

// HTML inicial
$dados = '
<html>
<head>
<style>
body {
  font-family: Arial, sans-serif;
}
h1 {
  color: #006d38;
  text-align: center;
  text-decoration: underline;
}
table {
  border-collapse: collapse;
  width: 100%;
  margin-top: 20px;
}
td, th {
  text-align: left;
  padding: 10px;
}
tr:nth-child(even) {
  background-color: #f2f2f2;
}
thead {
  background-color: #006d38;
  color: white;
}
</style>
</head>
<body>
';

$dados .= "<h1>Relatório de Faltas</h1>";
$dados .= "<table>
        <thead>
          <tr>
          <th>Nome do Usuário</th>
          <th>Total de Faltas</th>
          </tr>
        </thead>
        <tbody>";

$sql = "
  SELECT 
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

while ($linha = mysqli_fetch_assoc($resultado)) {
    $dados .= "<tr>";
    $dados .= '<td>' . $linha['usuario_nome'] . '</td>';
    $dados .= '<td>' . $linha['total_faltas'] . '</td>';
    $dados .= "</tr>";
}

$dados .= "</tbody>";
$dados .= "</table>";
$dados .= "</body></html>";

// Carrega o HTML no DOMPDF
$dompdf->loadHtml($dados);

// Define tamanho e orientação do papel
$dompdf->setPaper('A4', 'portrait');

// Renderizar o PDF
$dompdf->render();

// Enviar o PDF para o navegador
$dompdf->stream("relatorio_faltas.pdf", ["Attachment" => true]);
?>
