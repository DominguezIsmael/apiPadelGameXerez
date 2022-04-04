<?php

$email = $_GET['email'];
$password = $_GET['password'];

include('configuracion.inc.php');
$conexionBD = new mysqli($servidor, $usuario, $passwddb, $nombreBaseDatos);

$sql = "SELECT * FROM cliente WHERE email='$email' AND password=md5('$password')";
$resultado = $conexionBD->query($sql);

if($resultado->num_rows>0)
{
    echo json_encode($resultado->fetch_all(MYSQLI_ASSOC));
}
else
{
    echo json_encode(["success"=>0]);
}