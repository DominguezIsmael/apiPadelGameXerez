<?php

$email = $_GET['email'];
$password = $_GET['password'];

include('configuracion.inc.php');
$conexionBD = new mysqli($servidor, $usuario, $passwddb, $nombreBaseDatos);

$sqlLogin = mysqli_query($conexionBD,"SELECT * FROM cliente WHERE email='$email' AND password='$password'");

if(mysqli_num_rows($sqlLogin) > 0){
    $login = mysqli_fetch_all($sqlLogin, MYSQLI_ASSOC);
    echo json_encode($login);
    exit();
}
else{ echo json_encode(["success"=>0]); }