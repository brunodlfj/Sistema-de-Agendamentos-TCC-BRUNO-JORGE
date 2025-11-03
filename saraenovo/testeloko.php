<?php
include "conecta.php";

$sql = "SELECT * FROM diacontemplado WHERE dia >= CURRENT_DATE ORDER BY dia ASC LIMIT 5";  
$resultado = mysqli_query($conexao, $sql);

while ($linha = mysqli_fetch_array($resultado)) {

print_r($linha);
$diadasemana = date('N', strtotime($linha['dia']));
echo '<br>';
echo $diadasemana;
echo '<br>';
        $sqlconta = "SELECT COUNT(idAgendamento) AS total FROM agendamento WHERE idContemplado = $linha[idContemplado]";
        $resultadoconta = mysqli_query($conexao, $sqlconta);
        $total = mysqli_fetch_array($resultadoconta);
        $total = (int) $linha['quantidade'] - (int) $total['total'];
        echo $total;

        $sql2 = "SELECT * FROM atividade WHERE diadasemana = $diadasemana";  
        $resultado2 = mysqli_query($conexao, $sql2);
        while ($linha2 = mysqli_fetch_array($resultado2)) {
        print_r($linha2);
        };

       

        echo '<br>';
        echo '<br>';
        echo '<br>';
};


$sql = "INSERT INTO agendamento (id, idAtividade, idContemplado) VALUES ('$nomeAtividade', '$diaSemana', '$id')";

?>