<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include('configuracion.inc.php');
$conexionBD = new mysqli($servidor, $usuario, $passwddb, $nombreBaseDatos);

$usuario = $_GET['usuario'];
$password = $_GET['password'];

$sqlLogin = mysqli_query($conexionBD,"SELECT * FROM user WHERE usuario='$usuario' AND password=md5('$password')");

if(mysqli_num_rows($sqlLogin) > 0){
    $login = mysqli_fetch_all($sqlLogin, MYSQLI_ASSOC);
    echo json_encode($login);
    exit();
}
else{ echo json_encode(["success"=>0]); }