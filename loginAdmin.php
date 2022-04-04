<?php

$usuario = $_GET['usuario'];
$password = $_GET['password'];

include('configuracion.inc.php');
$conexionBD = new mysqli($servidor, $usuario, $passwddb, $nombreBaseDatos);

$sqlLogin = mysqli_query($conexionBD,"SELECT * FROM user WHERE usuario='$usuario' AND password=md5('$password')");

if(mysqli_num_rows($sqlLogin) > 0){
    $login = mysqli_fetch_all($sqlLogin, MYSQLI_ASSOC);
    echo json_encode($login);
    exit();
}
else{ echo json_encode(["success"=>0]); }