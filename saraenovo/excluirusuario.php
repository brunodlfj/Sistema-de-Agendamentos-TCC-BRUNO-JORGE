<!DOCTYPE html>
<html>
<head>
<title>Sarae IFFAR ug</title>
   <!--Import Google Icon Font-->
   <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<meta charset="UTF-8">
</head>
<link rel="shortcut icon" type=/image/png href="img/iconejanela.png" />
<body>
<?php
include "conecta.php";
$id = $_POST['id'];
echo $id;

$sql = "DELETE FROM usuario WHERE id=$id";
$resultado = mysqli_query($conexao,$sql);

mysqli_close($conexao);

if($resultado)
{
	header("Location:usuarios.php");
}

?>
</body>
</html>