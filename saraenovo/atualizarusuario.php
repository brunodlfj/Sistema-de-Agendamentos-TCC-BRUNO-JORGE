<?php
include "conecta.php";

$id = $_POST['id'];
$nivel = $_POST['nivel'];
$situacaousuario = $_POST['situacaousuario'];

$sql = "UPDATE usuario SET nivel='$nivel', situacaousuario='$situacaousuario' WHERE id='$id'";
$resultado = mysqli_query($conexao, $sql);

mysqli_close($conexao);

if ($resultado) {
    echo "<script>
        alert('Usuário atualizado com sucesso!');
        window.location.href = 'usuarios.php';
    </script>";
} else {
    echo "<script>
        alert('Erro ao atualizar usuário. Tente novamente.');
        window.history.back();
    </script>";
}
?>
